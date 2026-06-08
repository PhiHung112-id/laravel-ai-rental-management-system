<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Category; // Nhớ import model này
use App\Models\Location; // Nhớ import model này
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy danh sách phòng với bộ lọc (giữ nguyên logic của bro)
        $houses = House::with(['category', 'locationDetail']) // Đổi 'location' thành 'locationDetail'
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('house_no', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            })
            ->when($request->cat, function ($query) use ($request) {
                $query->where('category_id', $request->cat);
            })
            ->when($request->location_id, function ($query) use ($request) {
                $query->where('location_id', $request->location_id);
            })
            ->orderBy('id', 'asc')
            ->get();
        
        // 2. Lấy thêm danh sách Loại phòng và Khu vực để đổ vào ô Select trong View
        $categories = Category::all();
        $locations = Location::all();
        
        // 3. Truyền tất cả qua view
        return view('houses.index', compact('houses', 'categories', 'locations'));
    }

// app/Http/Controllers/HouseController.php
    public function show($id)
    {
        // 1. Lấy dữ liệu chính
        $house = \App\Models\House::with(['category', 'locationDetail'])->findOrFail($id);
        
        // 2. Logic kiểm tra trạng thái
        $is_rented = \App\Models\Tenant::where('house_id', $house->id)->where('status', 1)->exists();
        $is_sold = \App\Models\InstallmentRequest::where('house_id', $house->id)->where('status', 1)->exists();
        
        // --- ĐÂY LÀ PHẦN LOGIC BỊ THIẾU CẦN BỔ SUNG ---
        $is_available = (!$is_rented && !$is_sold);
        
        if ($is_sold) {
            $status_label = "Đã bán (Góp)";
            $status_class = "sold";
        } elseif ($is_rented) {
            $status_label = "Đã thuê";
            $status_class = "occupied";
        } else {
            $status_label = "Còn trống";
            $status_class = "available";
        }

        $sale_price_val = ($house->sale_price > 0) ? $house->sale_price : ($house->price * 100);
        $monthly_pay_calc = round($sale_price_val / 12);
        // ----------------------------------------------

        // 3. Xử lý ảnh gallery
        $gallery = [];
        if (!empty($house->img_path) && file_exists(public_path('assets/uploads/' . $house->img_path))) {
            $gallery[] = asset('assets/uploads/' . $house->img_path);
        } else {
            $gallery[] = asset('assets/uploads/no-image.jpg');
        }
        
        $extras = \App\Models\HouseImage::where('house_id', $id)->get();
        foreach($extras as $img) { 
            $gallery[] = asset('assets/uploads/' . $img->img_path); 
        }

        // 4. Lấy đánh giá
        $reviews = \App\Models\Review::with('customer')->where('house_id', $id)->orderBy('created_at', 'DESC')->get();

        // 5. Lấy phòng liên quan
        $related = \App\Models\House::where('category_id', $house->category_id)->where('id', '!=', $id)->limit(3)->get();

        // 6. Trả về view
        return view('houses.view', compact(
            'house', 
            'is_rented', 
            'is_sold', 
            'is_available', 
            'status_label', 
            'status_class', 
            'gallery', 
            'reviews', 
            'related',
            'sale_price_val', 
            'monthly_pay_calc'
        ));
    }
}