<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\LeatherOption;
use App\Models\HardwareOption;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['leatherOptions', 'hardwareOptions'])
            ->firstOrFail();
            
        return view('products.show', compact('product'));
    }
}