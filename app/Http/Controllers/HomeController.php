<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Customer;
use App\Models\Tenant;
use App\Models\InstallmentRequest;
use App\Models\Location;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Khối Thống kê
        $total_rooms = House::count();
        $total_customers = Customer::count();
        $rented_rooms = Tenant::where('status', 1)->distinct('house_id')->count('house_id');
        $sold_rooms = InstallmentRequest::where('status', 1)->distinct('house_id')->count('house_id');
        $available_rooms = max(0, $total_rooms - $rented_rooms - $sold_rooms);

        // 2. Khám phá khu vực (Đếm số phòng trống trong từng khu)
        $locations = Location::all()->map(function($loc) {
            $loc->empty_rooms = House::where('location_id', $loc->id)
                ->whereDoesntHave('tenants', function($q) { $q->where('status', 1); })
                ->whereDoesntHave('installmentRequests', function($q) { $q->where('status', 1); })
                ->count();
            return $loc;
        });

        // 3. Phòng mới cập nhật (6 phòng)
        $featured_rooms = House::with(['category', 'locationDetail'])
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        // 4. Đánh giá mới nhất (3 đánh giá kèm Customer)
        $reviews = Review::with('customer')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return view('welcome', compact(
            'total_rooms', 'total_customers', 'rented_rooms', 'sold_rooms', 
            'available_rooms', 'locations', 'featured_rooms', 'reviews'
        ));
    }
}