<?php
 
namespace App\Http\Controllers;
 
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService;
 
class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();
 
            if ($callback->isSuccess()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 2,
                ]);
            }
 
            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 3,
                ]);
            }
 
            if ($callback->isCancelled()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 4,
                ]);
            }

            $trans = new Transaction;
            $trans->upsert([
                [
                    'order_key' => $notification->order_id ?? null, 
                    'payment_type' => $notification->payment_type ?? null,
                    'total_price' => intval(str_replace(".", "", $notification->gross_amount)) ?? null,
                    'status' => $notification->status_message ?? null,
                    'bank' => $notification->va_numbers[0]->bank ?? null,
                    'va_number' => $notification->va_numbers[0]->va_number ?? null,
                    'fraud_status' => $notification->fraud_status ?? null,
                    'status_code' => $notification->status_code ?? null,
                    'transaction_id' => $notification->transaction_id ?? null,
                    'transaction_status' => $notification->transaction_status ?? null,
                    'transaction_time' => $notification->transaction_time ?? null,
                    'settlement_time' => $notification->settlement_time ?? null,
                ]
                ],
                [
                    'order_key'
                ]);
 
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}