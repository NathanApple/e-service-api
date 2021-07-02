<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    //
    public function check(Request $request){
        try{
            $merchant = $request->merchant;
            $user = Auth::user();
            return response()->json(compact('merchant', 'user'));
        } catch (Exception $e){
            return response()->json(['message'=>'Route is not protected'], 500);
        }
    }
}
