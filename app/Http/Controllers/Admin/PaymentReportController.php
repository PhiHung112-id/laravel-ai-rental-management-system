<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

class PaymentReportController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $month_of = $request->month_of ?? date('Y-m');

        $payments = Payment::with([
            'tenant.house'
        ])
        ->whereYear('created_at', date('Y', strtotime($month_of . '-01')))
        ->whereMonth('created_at', date('m', strtotime($month_of . '-01')))
        ->orderBy('created_at', 'asc')
        ->get();

        $tamount = $payments->sum('amount');

        return view(
            'admin.reports.payment_report',
            compact(
                'payments',
                'month_of',
                'tamount'
            )
        );
    }
}