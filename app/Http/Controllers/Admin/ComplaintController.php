<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use Throwable;

class ComplaintController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $complaints = Complaint::with(['tenant.house'])
            ->orderBy('status', 'asc')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function manage($id = null)
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $complaint = $id ? Complaint::find($id) : null;

        $tenants = Tenant::with('house')
            ->where('status', 1)
            ->get();

        return view('admin.complaints.manage', compact('complaint', 'tenants'));
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'tenant_id' => 'required|exists:tenants,id',
                'report' => 'required|string',
                'status' => 'required|in:0,1,2',
                'cost' => 'nullable|numeric|min:0',
            ]);

            $tenant = Tenant::findOrFail($request->tenant_id);

            $complaint = $request->id
                ? Complaint::findOrFail($request->id)
                : new Complaint();

            $complaint->tenant_id = $tenant->id;
            $complaint->house_id = $tenant->house_id;
            $complaint->report = $request->report;
            $complaint->status = $request->status;
            $complaint->cost = $request->cost ?? 0;

            $complaint->save();

            return response('1');

        } catch (\Throwable $e) {
            return response('Lỗi save complaint: '.$e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response('0');
        }

        $complaint->delete();

        return response('1');
    }
}