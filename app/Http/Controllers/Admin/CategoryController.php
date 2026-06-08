<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $categories = Category::orderBy('id', 'asc')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function save(Request $request)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->id) {
            $category = Category::find($request->id);

            if (!$category) {
                return response('0');
            }

            $category->name = $request->name;
            $category->save();

            return response('1');
        }

        Category::create([
            'name' => $request->name,
        ]);

        return response('1');
    }

    public function delete($id)
    {
        if (!session()->has('login_id')) {
            return response('0');
        }

        $category = Category::find($id);

        if (!$category) {
            return response('0');
        }

        $category->delete();

        return response('1');
    }
}