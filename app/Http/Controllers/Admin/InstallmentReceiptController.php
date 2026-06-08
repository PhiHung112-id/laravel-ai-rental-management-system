<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InstallmentPayment;

class InstallmentReceiptController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $receipts = InstallmentPayment::with([
            'request.customer',
            'request.house'
        ])
        ->orderBy('status','asc')
        ->orderByDesc('created_at')
        ->get();

        return view(
            'admin.installments.receipts',
            compact('receipts')
        );
    }

    public function updateStatus(Request $request)
    {
        try{

            $receipt = InstallmentPayment::findOrFail($request->id);

            $receipt->status = $request->status;

            $receipt->save();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }

    public function delete($id)
    {
        try{

            $receipt = InstallmentPayment::findOrFail($id);

            $receipt->delete();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }
}