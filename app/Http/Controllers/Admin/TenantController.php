<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tenant;
use App\Models\House;
use App\Models\Payment;

class TenantController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $tenants = Tenant::with('house','payments')
            ->where('status',1)
            ->orderByDesc('house_id')
            ->get();

        return view('admin.tenants.index',compact('tenants'));
    }

    public function manage($id = null)
    {
        $tenant = $id ? Tenant::find($id) : null;

        $houses = House::whereNotIn('id', function($q){
            $q->select('house_id')
              ->from('tenants')
              ->where('status',1);
        })
        ->when($tenant,function($q) use($tenant){
            $q->orWhere('id',$tenant->house_id);
        })
        ->get();

        return view(
            'admin.tenants.manage',
            compact('tenant','houses')
        );
    }

    public function save(Request $request)
    {
        $tenant = $request->id
            ? Tenant::find($request->id)
            : new Tenant();

        $tenant->firstname = $request->firstname;
        $tenant->middlename = $request->middlename;
        $tenant->lastname = $request->lastname;
        $tenant->contact = $request->contact;
        $tenant->email = $request->email;
        $tenant->house_id = $request->house_id;
        $tenant->date_in = $request->date_in;
        $tenant->status = 1;

        $tenant->save();

        return response('1');
    }

    public function delete($id)
    {
        $tenant = Tenant::find($id);

        if(!$tenant){
            return response('0');
        }

        $tenant->delete();

        return response('1');
    }

    public function paymentHistory($id)
    {
        $tenant = Tenant::with([
            'house',
            'payments'
        ])->findOrFail($id);

        return view(
            'admin.tenants.payment_history',
            compact('tenant')
        );
    }

    public function printContract($id)
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $tenant = Tenant::with('house')->findOrFail($id);

        return view('admin.tenants.print_contract', compact('tenant'));
    }
}