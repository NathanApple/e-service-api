<?php

namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceTransactionController extends Controller
{

    public function view_start_transaction(Request $request){
        return view('form_start_transaction');

    }

    public function start_transaction(Request $request){
        $transaction = new ServiceTransaction();

        $transaction->user_id = $request->user_id;
        $transaction->service_id = $request->service_id;
        $transaction->price = $request->price;
        $transaction->transaction_status = 'Not Confirmed';
        

        $transaction->save();

        return dump($transaction);
        
    }

    public function accept_transaction(Request $request, $id){

        // Note ini pake $id untuk mempercepat testing
        $transaction = ServiceTransaction::findOrFail($id);

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
                return 'Transaksi telah dilakukan ( Sudah dibayar )';
            }
            return dump($e);
        }

        // return dump($snapToken);
        return view('transaction_integration', compact('snapToken', 'transaction'));
        
    }

    public function check_transaction(Request $request, $id){
        $transaction = ServiceTransaction::where('order_id', $id)->first();
        return dump($transaction);
    }
}
