<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('landing_page'); // Your existing landing page
    }

    public function showSatchel()
    {
        return view('products.satchel');
    }
}