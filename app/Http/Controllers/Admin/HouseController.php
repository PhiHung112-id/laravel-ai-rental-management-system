<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HouseImage;

class HouseController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $houses = House::with(['category', 'location'])
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.houses.index', compact('houses'));
    }

    public function delete($id)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $house = House::find($id);

        if (!$house) {
            return response('0');
        }

        $house->delete();

        return response('1');
    }

    public function manage($id = null)
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $house = $id ? House::with('images')->find($id) : null;
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.houses.manage', compact('house', 'categories'));
    }

    public function save(Request $request)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        if ($request->price < 0) {
            return response('3');
        }

        $exists = House::where('house_no', $request->house_no)
            ->when($request->id, function ($q) use ($request) {
                $q->where('id', '!=', $request->id);
            })
            ->exists();

        if ($exists) {
            return response('2');
        }

        $house = $request->id ? House::find($request->id) : new House();

        $house->house_no = $request->house_no;
        $house->location = $request->location;
        $house->map_link = $request->map_link;
        $house->category_id = $request->category_id;
        $house->description = $request->description;
        $house->price = $request->price;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/uploads'), $filename);
            $house->img_path = $filename;
        }

        $house->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $filename = time().'_'.uniqid().'_'.$img->getClientOriginalName();
                $img->move(public_path('assets/uploads'), $filename);

                HouseImage::create([
                    'house_id' => $house->id,
                    'img_path' => $filename,
                ]);
            }
        }

        return response('1');
    }

    public function deleteImage($id)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $img = HouseImage::find($id);

        if (!$img) {
            return response('0');
        }

        $path = public_path('assets/uploads/'.$img->img_path);

        if (file_exists($path)) {
            @unlink($path);
        }

        $img->delete();

        return response('1');
    }
}