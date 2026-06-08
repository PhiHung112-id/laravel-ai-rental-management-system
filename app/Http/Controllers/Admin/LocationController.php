<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\House;

class LocationController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $locations = Location::orderBy('location_name', 'asc')->get();

        return view('admin.locations.index', compact('locations'));
    }

    public function save(Request $request)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $request->validate([
            'location_name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        if ($request->id) {
            $location = Location::find($request->id);

            if (!$location) {
                return response('0');
            }
        } else {
            $location = new Location();
        }

        $location->location_name = $request->location_name;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/uploads'), $filename);

            if ($request->id && !empty($location->img_path)) {
                $oldPath = public_path('assets/uploads/' . $location->img_path);

                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $location->img_path = $filename;
        }

        $location->save();

        return response('1');
    }

    public function delete($id)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $hasHouse = House::where('location_id', $id)->exists();

        if ($hasHouse) {
            return response('3');
        }

        $location = Location::find($id);

        if (!$location) {
            return response('0');
        }

        if (!empty($location->img_path)) {
            $oldPath = public_path('assets/uploads/' . $location->img_path);

            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $location->delete();

        return response('1');
    }
}