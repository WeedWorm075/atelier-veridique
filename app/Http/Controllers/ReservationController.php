<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\LeatherOption;
use App\Models\HardwareOption;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function personalization()
    {
        $product = Product::where('slug', 'artisan-satchel')->first();
        $leatherOptions = LeatherOption::where('available', true)->get();
        $hardwareOptions = HardwareOption::where('available', true)->get();
        
        $orderData = Session::get('order_data', [
            'leather_option_id' => $leatherOptions->first()->id ?? null,
            'hardware_option_id' => $hardwareOptions->first()->id ?? null,
            'monogram' => 'F•L',
            'monogram_price' => 25,
            'base_price' => $product->base_price ?? 420,
            'total' => 445
        ]);
        
        return view('reservations.personalization', compact(
            'product',
            'leatherOptions',
            'hardwareOptions',
            'orderData'
        ));
    }
    
    public function updatePersonalization(Request $request)
    {
        $request->validate([
            'leather_option_id' => 'required|exists:leather_options,id',
            'hardware_option_id' => 'required|exists:hardware_options,id',
            'monogram' => 'nullable|string|max:10'
        ]);
        
        $orderData = Session::get('order_data', []);
        $orderData = array_merge($orderData, $request->only([
            'leather_option_id',
            'hardware_option_id',
            'monogram'
        ]));
        
        // Calculate prices
        $product = Product::where('slug', 'artisan-satchel')->first();
        $leatherOption = LeatherOption::find($request->leather_option_id);
        $hardwareOption = HardwareOption::find($request->hardware_option_id);
        
        $orderData['base_price'] = $product->base_price;
        $orderData['monogram_price'] = $request->filled('monogram') ? 25 : 0;
        $orderData['total'] = $product->base_price 
            + ($leatherOption->price_modifier ?? 0)
            + ($hardwareOption->price_modifier ?? 0)
            + $orderData['monogram_price'];
        
        Session::put('order_data', $orderData);
        
        return response()->json([
            'success' => true,
            'order_data' => $orderData
        ]);
    }
}