<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMerchant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next, $guard = null)
    {
        if($guard != null)
            auth()->shouldUse($guard);
        // Pre-Middleware Action
        if( Auth::user()){
            try{
                $user_id =Auth::user()->id;
                $merchant = Merchant::where('user_id',  $user_id)->firstOrFail();
                // $request->merchant->add(compact('merchant'));
                $request->request->add(compact('merchant'));
                return $next($request);

            } catch (ModelNotFoundException $e){
                return response()->json(['message'=>'User is not merchant'], 401);

            }
        } else {
            return response()->json(['message'=>'User is not logged in'], 401);

        }


        // Post-Middleware Action
        // $response = $next($request);

        return $next($request);
    }
}
