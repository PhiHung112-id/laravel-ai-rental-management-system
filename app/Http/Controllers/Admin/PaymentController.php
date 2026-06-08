<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Tenant;

class PaymentController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $payments = Payment::with([
            'tenant.house'
        ])
        ->orderByDesc('created_at')
        ->get();

        return view(
            'admin.payments.index',
            compact('payments')
        );
    }

    public function manage($id = null)
    {
        $payment = $id
            ? Payment::find($id)
            : null;

        $tenants = Tenant::with('house')
            ->where('status',1)
            ->get();

        return view(
            'admin.payments.manage',
            compact('payment','tenants')
        );
    }

    public function save(Request $request)
    {
        try {

            $payment = $request->id
                ? Payment::find($request->id)
                : new Payment();

            if(!$payment){
                return response('0');
            }

            $payment->tenant_id = $request->tenant_id;
            $payment->invoice = $request->invoice;
            $payment->cost_electric = $request->cost_electric;
            $payment->cost_water = $request->cost_water;
            $payment->amount = $request->amount;

            $payment->save();

            return response('1');

        } catch (\Throwable $e) {

            return response($e->getMessage(),500);

        }
    }

    public function delete($id)
    {
        try {

            $payment = Payment::findOrFail($id);

            $payment->delete();

            return response('1');

        } catch (\Throwable $e) {

            return response($e->getMessage(),500);

        }
    }
}