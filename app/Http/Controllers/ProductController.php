<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create(Request $request){
        // $user_id = Auth::user()->id;
        // TODO : Get merchant id from Token
        
        $merchant_id = $request->merchant->id;
        $product = new Product();

        $product->merchant_id = $merchant_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->available = $request->available;
        $product->negotiable = $request->negotiable;
        $product->description = $request->description;

        // TODO : Implement Category
        // $product->category = $request->category;

        $product->save();

        return response()->json($product);
        
    }

}
