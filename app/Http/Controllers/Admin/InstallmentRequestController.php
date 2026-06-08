<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InstallmentRequest;

class InstallmentRequestController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $requests = InstallmentRequest::with('customer')
            ->orderByDesc('created_at')
            ->get();

        return view(
            'admin.installments.index',
            compact('requests')
        );
    }

    public function updateStatus(Request $request)
    {
        try {

            $requestItem = InstallmentRequest::findOrFail($request->id);

            $requestItem->status = $request->status;

            $requestItem->save();

            return response('1');

        } catch (\Throwable $e) {

            return response($e->getMessage(),500);
        }
    }

    public function delete($id)
    {
        try {

            $requestItem = InstallmentRequest::findOrFail($id);

            $requestItem->delete();

            return response('1');

        } catch (\Throwable $e) {

            return response($e->getMessage(),500);
        }
    }

    public function view($id)
    {
        $requestItem = InstallmentRequest::with('customer')
            ->findOrFail($id);

        return view(
            'admin.installments.view',
            compact('requestItem')
        );
    }
}