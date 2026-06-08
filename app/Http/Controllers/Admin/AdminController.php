<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\House;
use App\Models\Tenant;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        // Tổng số phòng
        $totalHouses = House::count();

        // Khách đang thuê
        $activeTenants = Tenant::where('status', 1)->count();

        // Phòng trống
        $emptyHouses = max($totalHouses - $activeTenants, 0);

        // Doanh thu tháng hiện tại
        $monthlyRevenue = DB::table('payments')
            ->whereRaw("DATE_FORMAT(created_at,'%Y-%m') = ?", [date('Y-m')])
            ->sum('amount');

        // Data biểu đồ
        $revenueData = [];
        $monthsLabels = [];

        for ($i = 5; $i >= 0; $i--) {

            $monthDb = date('Y-m', strtotime("-$i months"));

            $monthsLabels[] = 'Tháng ' . date('m', strtotime("-$i months"));

            $total = DB::table('payments')
                ->whereRaw("DATE_FORMAT(created_at,'%Y-%m') = ?", [$monthDb])
                ->sum('amount');

            $revenueData[] = $total;
        }

        return view('admin.dashboard', compact(
            'totalHouses',
            'activeTenants',
            'emptyHouses',
            'monthlyRevenue',
            'revenueData',
            'monthsLabels'
        ));
    }

    public function login(Request $request)
    {
        $user = User::where('email', trim($request->username))
            ->where('password', md5(trim($request->password)))
            ->first();

        if (!$user) {
            return response('0');
        }

        session([
            'login_id' => $user->id,
            'login_name' => $user->name,
            'login_username' => $user->email,
            'login_type' => 1,
        ]);

        return response('1');
    }

    public function logout()
    {
        session()->forget([
            'login_id',
            'login_name',
            'login_type',
            'login_username',
        ]);

        return redirect('/admin/login');
    }
}