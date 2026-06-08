<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UtilityReading;
use App\Models\House;

class UtilityController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $readings = UtilityReading::with([
            'house.tenants'
        ])
        ->orderByDesc('reading_date')
        ->get();

        return view(
            'admin.utilities.index',
            compact('readings')
        );
    }

    public function manage($id = null)
    {
        $reading = $id
            ? UtilityReading::find($id)
            : null;

        $houses = House::all();

        return view(
            'admin.utilities.manage',
            compact('reading','houses')
        );
    }

    public function save(Request $request)
    {
        try{

            $reading = $request->id
                ? UtilityReading::find($request->id)
                : new UtilityReading();

            if(!$reading){
                return response('0');
            }

            $reading->house_id = $request->house_id;
            $reading->electric = $request->electric;
            $reading->water = $request->water;
            $reading->reading_date = $request->reading_date;

            $reading->save();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }

    public function delete($id)
    {
        try{

            $reading = UtilityReading::findOrFail($id);

            $reading->delete();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }
}