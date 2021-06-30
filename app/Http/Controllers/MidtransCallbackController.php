<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function callback(){
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        error_log("Order ID $notif->order_id: "."transaction status = $transaction, fraud staus = $fraud");

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
            // TODO Set payment status in merchant's database to 'challenge'
            }
            else if ($fraud == 'accept') {
            // TODO Set payment status in merchant's database to 'success'
            }
        }
        else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
            // TODO Set payment status in merchant's database to 'failure'
            }
            else if ($fraud == 'accept') {
            // TODO Set payment status in merchant's database to 'failure'
            }
        }
        else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
        }
    }
}
