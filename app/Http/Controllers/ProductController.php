<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request){
        $merchant_id = "1";
        $product = new Product();

        $product->merchant_id = $merchant_id;
        $product->product_name = $request->product_name;
        $product->lowest_price = $request->lowest_price;
        $product->available = $request->available;
        $product->description = $request->description;

        $product->save();

        return response()->json($product);
        
    }

    

    public function form_create(Request $request){
        return view('form_product');
    }
}
