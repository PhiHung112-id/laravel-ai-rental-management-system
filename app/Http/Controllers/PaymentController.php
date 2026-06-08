<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstallmentPayment;

class PaymentController extends Controller
{
    public function mockVnpay(Request $request)
    {
        $req_id = $request->get('req_id', 0);
        $period = $request->get('period', 0);
        $amount = $request->get('amount', 0);
        $info = $request->get('info', 'Thanh toan don hang');
        $txn_ref = time() . rand(100, 999);

        $qr_data = "QUANGIA_PAY_TXN:" . $txn_ref . "_AMT:" . $amount;

        return view('payments.mock_vnpay', compact(
            'req_id',
            'period',
            'amount',
            'info',
            'txn_ref',
            'qr_data'
        ));
    }

    public function vnpayReturn(Request $request)
    {
        $response_code = $request->get('vnp_ResponseCode', '');
        $req_id = (int) $request->get('req_id', 0);
        $period = (int) $request->get('period', 0);
        $amount = (float) $request->get('amount', 0);
        $txn_ref = $request->get('vnp_TxnRef', '');

        $is_success = $response_code === '00';

        if ($is_success) {
            $exists = InstallmentPayment::where('request_id', $req_id)
                ->where('month_no', $period)
                ->exists();

            if (!$exists) {
                InstallmentPayment::create([
                    'request_id' => $req_id,
                    'month_no' => $period,
                    'amount' => $amount,
                    'receipt_img' => 'VNPAY_' . $txn_ref . '.png',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return view('payments.vnpay_return', compact(
            'is_success',
            'req_id',
            'period',
            'amount',
            'txn_ref'
        ));
    }
}