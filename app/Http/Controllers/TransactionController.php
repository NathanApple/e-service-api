<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    public function start_negotiable_transaction(Request $request){

        // TODO : Validate, if the current user is the owner of the product
        $transaction = new Transaction();

        $transaction->user_id = $request->buyer_user_Id;
        $transaction->product_id = $request->product_id;
        $transaction->price = $request->price;
        $transaction->transaction_status = 'Not Confirmed';
        

        $transaction->save();

        return response()->json(compact('transaction'));
        
    }

    public function accept_transaction(Request $request){

        // Note ini pake $id untuk mempercepat testing
        // TODO : Check user not confirmed transaction
        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($transaction->order_id == null){
            $uuid = Uuid::uuid4()->toString();
            $transaction->order_id = $uuid;
            $transaction->transaction_status = "pending payment";    
            $transaction->save();
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction->order_id,
                'gross_amount' => $transaction->price,
            )
        );
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (Exception $e) {    
            // Kalo ada tambahan Error bisa tulis disini

            // 400 : OrderId sudah pernah dipakai sebelumnya
            if ($e->getCode() == '400'){   
                return response()->json([
                    'message' => 'Transaksi telah dilakukan atau OrderId telah dipakai sebelumnya '
                ], 400);
            }

            $message = $e->getMessage();
            Log::debug('Error when accept transaction : '.$message);
            return response()->json([
                'message' => "Unknown Error, please contact developer, error : $message"
            ], $e->getCode());
        }

        // return dump($snapToken);
        return response()->json(compact('snapToken', 'transaction'));
        
    }

    public function check_transaction(Request $request, $id){
        $transaction = Transaction::where('order_id', $id)->first();
        return response()->json(compact('transaction'));
    }
}
