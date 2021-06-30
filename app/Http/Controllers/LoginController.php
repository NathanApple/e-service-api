<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){
        $token = app('auth')->attempt($request->only('email', 'password'));
        return response()->json(compact('token'));
    }

    
}
