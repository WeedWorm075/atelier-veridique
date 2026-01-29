<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'leatherOption', 'hardwareOption'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $orders = $query->paginate(20);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'leatherOption', 'hardwareOption', 'statusHistory', 'paymentLogs']);
        
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_production,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($order, $request) {
            $order->updateStatus($request->status, $request->notes);
        });

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'card_last_four' => 'nullable|string|size:4',
            'card_brand' => 'nullable|string|max:50',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'card_last_four' => $request->card_last_four,
            'card_brand' => $request->card_brand,
        ]);

        return redirect()->back()
            ->with('success', 'Payment status updated successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'base_price' => 'required|numeric|min:0',
            'monogram_price' => 'numeric|min:0',
            'shipping_price' => 'numeric|min:0',
            'leather_option_id' => 'nullable|exists:leather_options,id',
            'hardware_option_id' => 'nullable|exists:hardware_options,id',
            'customer_email' => 'required|email',
            'customer_first_name' => 'required|string|max:100',
            'customer_last_name' => 'required|string|max:100',
            'customer_phone' => 'nullable|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'terms_accepted' => 'required|accepted',
        ]);

        // Calculate total amount
        $total = $validated['base_price'] 
               + ($validated['monogram_price'] ?? 0) 
               + ($validated['shipping_price'] ?? 0);
        
        // Add price modifiers from options if needed
        // This would require loading the options and adding their price_modifier

        $order = Order::create(array_merge($validated, [
            'status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'total_amount' => $total,
            'send_receipt' => true,
        ]));

        // Generate order number if not set
        if (empty($order->order_number)) {
            $order->update([
                'order_number' => $order->generateOrderNumber(),
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order created successfully.');
    }

    public function statistics()
    {
        $statistics = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'revenue_today' => Order::whereDate('created_at', today())
                ->where('payment_status', Order::PAYMENT_STATUS_PAID)
                ->sum('total_amount'),
            'revenue_month' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', Order::PAYMENT_STATUS_PAID)
                ->sum('total_amount'),
            'average_order_value' => Order::where('payment_status', Order::PAYMENT_STATUS_PAID)
                ->avg('total_amount'),
            'orders_to_ship' => Order::where('status', Order::STATUS_IN_PRODUCTION)
                ->whereNull('shipped_date')
                ->count(),
        ];

        return response()->json($statistics);
    }
}