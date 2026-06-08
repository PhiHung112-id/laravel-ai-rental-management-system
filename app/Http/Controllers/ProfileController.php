<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Complaint;
use App\Models\InstallmentRequest;
use App\Models\Tenant;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session()->has('login_customer_id')) {
            return redirect()->route('login');
        }

        $customerId = session('login_customer_id');

        $user = Customer::findOrFail($customerId);

        $realTenantId = 0;

        $tenant = Tenant::where('email', $user->email)
            ->where('status', 1)
            ->first();

        if ($tenant) {
            $realTenantId = $tenant->id;
        }

        $bookings = Booking::with(['house.category'])
            ->where('customer_id', $customerId)
            ->orderBy('id', 'desc')
            ->get();

        $installments = InstallmentRequest::with('house')
            ->where('customer_id', $customerId)
            ->orderBy('id', 'desc')
            ->get();

        $complaints = collect();

        if ($realTenantId > 0) {
            $complaints = Complaint::with('house')
                ->where('tenant_id', $realTenantId)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('profile.index', compact(
            'user',
            'bookings',
            'installments',
            'realTenantId',
            'complaints'
        ));
    }

    public function update(Request $request)
    {
        if (!session()->has('login_customer_id')) {
            return response('0');
        }

        $user = Customer::find(session('login_customer_id'));

        if (!$user) {
            return response('0');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:1',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if (!empty($request->password)) {
            $user->password = md5($request->password);
        }

        if ($request->hasFile('img')) {
            $file = $request->file('img');

            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            $uploadPath = public_path('assets/uploads');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file->move($uploadPath, $filename);

            $user->avatar = $filename;
        }

        $user->save();

        session([
            'login_customer_name' => $user->name,
            'login_avatar' => $user->avatar,
        ]);

        return response('1');
    }

    public function storeComplaint(Request $request)
    {
        if (!session()->has('login_customer_id')) {
            return response('0');
        }

        $request->validate([
            'tenant_id' => 'required|integer',
            'house_id' => 'required|integer',
            'report' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $filename = null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');

            $filename = 'complaint_' . time() . '.' . $file->getClientOriginalExtension();

            $uploadPath = public_path('assets/uploads');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file->move($uploadPath, $filename);
        }

        Complaint::create([
            'tenant_id' => $request->tenant_id,
            'house_id' => $request->house_id,
            'report' => $request->report,
            'status' => 0,
            'cost' => 0,
            'img_path' => $filename,
        ]);

        return response('1');
    }
}