<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\LeatherOption;
use App\Models\HardwareOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function show()
    {
        $orderData = Session::get('order_data');
        
        if (!$orderData) {
            return redirect()->route('reservations.personalization');
        }
        
        $product = Product::where('slug', 'artisan-satchel')->first();
        $leatherOption = LeatherOption::find($orderData['leather_option_id'] ?? null);
        $hardwareOption = HardwareOption::find($orderData['hardware_option_id'] ?? null);
        
        return view('checkout.show', compact(
            'orderData',
            'product',
            'leatherOption',
            'hardwareOption'
        ));
    }
    
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_first_name' => 'required|string|max:100',
            'customer_last_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'shipping_method' => 'required|in:standard,express',
            'payment_method' => 'required|in:card,paypal,apple_pay,bank_transfer',
            'billing_same_as_shipping' => 'boolean',
            
            // Payment details (conditional)
            'card_name' => 'required_if:payment_method,card',
            'card_number' => 'required_if:payment_method,card',
            'expiry_date' => 'required_if:payment_method,card',
            'cvc' => 'required_if:payment_method,card',
            
            // Terms and preferences
            'terms_accepted' => 'required|accepted',
            'send_receipt' => 'boolean',
            'newsletter_subscription' => 'boolean',
        ]);
        
        $orderData = Session::get('order_data');
        
        if (!$orderData) {
            return redirect()->back()->withErrors(['error' => 'Order data not found. Please start over.']);
        }
        
        DB::beginTransaction();
        
        try {
            // Create order
            $order = new Order();
            $order->order_number = $order->generateOrderNumber();
            $order->status = 'confirmed';
            $order->payment_status = 'pending';
            
            // Personalization
            $order->leather_option_id = $orderData['leather_option_id'];
            $order->hardware_option_id = $orderData['hardware_option_id'];
            $order->monogram = $orderData['monogram'] ?? null;
            
            // Prices
            $order->base_price = $orderData['base_price'];
            $order->monogram_price = $orderData['monogram_price'];
            $order->shipping_price = $validated['shipping_method'] === 'express' ? 15 : 0;
            $order->total_amount = $order->calculateTotal();
            
            // Customer info
            $order->customer_first_name = $validated['customer_first_name'];
            $order->customer_last_name = $validated['customer_last_name'];
            $order->customer_email = $validated['customer_email'];
            $order->customer_phone = $validated['customer_phone'];
            
            // Shipping info
            $order->shipping_address = $validated['shipping_address'];
            $order->shipping_city = $validated['shipping_city'];
            $order->shipping_zip_code = $validated['shipping_zip_code'];
            $order->shipping_country = $validated['shipping_country'];
            $order->shipping_method = $validated['shipping_method'];
            
            // Billing info
            if ($request->billing_same_as_shipping) {
                $order->billing_address = $validated['shipping_address'];
                $order->billing_city = $validated['shipping_city'];
                $order->billing_zip_code = $validated['shipping_zip_code'];
                $order->billing_country = $validated['shipping_country'];
            } else {
                $order->billing_address = $request->billing_address;
                $order->billing_city = $request->billing_city;
                $order->billing_zip_code = $request->billing_zip_code;
                $order->billing_country = $request->billing_country;
            }
            
            // Payment info
            $order->payment_method = $validated['payment_method'];
            
            if ($validated['payment_method'] === 'card') {
                $order->card_last_four = substr($validated['card_number'], -4);
                $order->card_brand = $this->detectCardBrand($validated['card_number']);
            }
            
            // Preferences
            $order->send_receipt = $validated['send_receipt'] ?? true;
            $order->newsletter_subscription = $validated['newsletter_subscription'] ?? false;
            $order->terms_accepted = true;
            
            // Production timeline
            $order->estimated_production_days = 21;
            $order->production_start_date = now()->addDays(2);
            
            $order->save();
            
            // Create status history
            $order->statusHistory()->create([
                'status' => 'confirmed',
                'notes' => 'Order placed successfully'
            ]);
            
            // If payment is card, process payment
            if ($validated['payment_method'] === 'card') {
                // Process payment with payment gateway (Stripe, etc.)
                $paymentResult = $this->processPayment($order, $validated);
                
                if ($paymentResult['success']) {
                    $order->payment_status = 'paid';
                    $order->status = 'in_production';
                    
                    $order->statusHistory()->create([
                        'status' => 'payment_received',
                        'notes' => 'Payment processed successfully'
                    ]);
                } else {
                    $order->payment_status = 'failed';
                    $order->status = 'payment_failed';
                    
                    $order->statusHistory()->create([
                        'status' => 'payment_failed',
                        'notes' => $paymentResult['message']
                    ]);
                }
                
                $order->save();
            }
            
            // Send confirmation email
            if ($order->send_receipt) {
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            }
            
            DB::commit();
            
            // Clear session data
            Session::forget('order_data');
            
            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'redirect_url' => route('checkout.confirmation', $order->order_number)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your order. Please try again.'
            ], 500);
        }
    }
    
    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return view('checkout.confirmation', compact('order'));
    }
    
    private function detectCardBrand($cardNumber)
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        
        if (preg_match('/^4/', $cardNumber)) {
            return 'visa';
        } elseif (preg_match('/^5[1-5]/', $cardNumber)) {
            return 'mastercard';
        } elseif (preg_match('/^3[47]/', $cardNumber)) {
            return 'american_express';
        } else {
            return 'unknown';
        }
    }
    
    private function processPayment($order, $data)
    {
        // In a real application, integrate with Stripe, PayPal, etc.
        // For demonstration, simulate payment processing
        
        try {
            // Simulate payment gateway call
            // $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            // $paymentIntent = $stripe->paymentIntents->create([
            //     'amount' => $order->total_amount * 100,
            //     'currency' => 'eur',
            //     'payment_method' => $data['payment_method_id'],
            //     'confirmation_method' => 'manual',
            //     'confirm' => true,
            // ]);
            
            // For demo purposes, always succeed
            return [
                'success' => true,
                'transaction_id' => 'sim_' . Str::random(20),
                'message' => 'Payment successful'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}