<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tenant;
use App\Models\Payment;

class BalanceReportController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $tenants = Tenant::with([
            'house',
            'payments'
        ])
        ->where('status',1)
        ->orderByDesc('house_id')
        ->get();

        return view(
            'admin.reports.balance_report',
            compact('tenants')
        );
    }
}