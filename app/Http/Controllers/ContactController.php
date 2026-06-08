<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        try {
            \DB::table('contacts')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response('1');

        } catch (\Throwable $e) {
            return response($e->getMessage(), 500);
        }
    }
}