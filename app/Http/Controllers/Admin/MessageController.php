<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Throwable;

class MessageController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $messages = Contact::orderByDesc('created_at')
            ->get();

        return view(
            'admin.messages.index',
            compact('messages')
        );
    }

    public function delete($id)
    {
        try {

            $message = Contact::find($id);

            if (!$message) {
                return response('0');
            }

            $message->delete();

            return response('1');

        } catch (Throwable $e) {

            return response($e->getMessage(),500);

        }
    }
}