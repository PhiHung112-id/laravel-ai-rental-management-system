<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $reviews = Review::with([
            'customer',
            'house'
        ])
        ->orderByDesc('created_at')
        ->get();

        return view(
            'admin.reviews.index',
            compact('reviews')
        );
    }

    public function manage($id)
    {
        $review = Review::findOrFail($id);

        return view(
            'admin.reviews.manage',
            compact('review')
        );
    }

    public function save(Request $request)
    {
        try{

            $review = Review::findOrFail($request->id);

            $review->admin_reply = $request->admin_reply;

            $review->save();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }

    public function delete($id)
    {
        try{

            $review = Review::findOrFail($id);

            $review->delete();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }
}