<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $bookings = Booking::with([
            'customer',
            'house.category'
        ])
        ->orderByDesc('id')
        ->get();

        return view(
            'admin.bookings.index',
            compact('bookings')
        );
    }

    public function updateStatus(Request $request)
    {
        try{

            $booking = Booking::findOrFail($request->id);

            $booking->status = $request->status;

            $booking->save();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }

    public function delete($id)
    {
        try{

            $booking = Booking::findOrFail($id);

            $booking->delete();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }
}