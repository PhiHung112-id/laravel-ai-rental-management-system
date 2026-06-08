<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\InstallmentRequest;
use Illuminate\Http\Request;
use App\Models\InstallmentPayment;

class InstallmentController extends Controller
{
    public function index()
    {
        $rooms = House::all();

        return view('installment.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        if (!session()->has('login_customer_id')) {
            return response('3');
        }

        $customerId = session('login_customer_id');

        $exists = InstallmentRequest::where('customer_id', $customerId)
            ->where('house_id', $request->house_id)
            ->where('status', 0)
            ->exists();

        if ($exists) {
            return response('2');
        }

        InstallmentRequest::create([
            'house_id' => $request->house_id,
            'customer_id' => $customerId,
            'room_info' => $request->room_info,
            'total_price' => $request->total_price,
            'months' => $request->months,
            'monthly_pay' => $request->monthly_pay,
            'status' => 0,
        ]);

        return response('1');
    }

        public function detail($id)
    {
        if (!session()->has('login_customer_id')) {
            return redirect()->route('login');
        }

        $customerId = session('login_customer_id');

        $req = InstallmentRequest::with([
            'house.category',
            'house.location'
        ])
        ->where('id', $id)
        ->where('customer_id', $customerId)
        ->first();

        if (!$req) {
            return redirect()->route('profile.index')
                ->with('error', 'Không tìm thấy hợp đồng');
        }

        $sale_price = $req->house->sale_price > 0
            ? $req->house->sale_price
            : ($req->house->price * 100);

        $months = $req->months ?: 12;

        $monthly_pay = round($sale_price / $months);

        $paid_data = InstallmentPayment::where('request_id', $req->id)
            ->pluck('status', 'month_no')
            ->toArray();

        return view('installment.detail', compact(
            'req',
            'sale_price',
            'months',
            'monthly_pay',
            'paid_data'
        ));
    }
}