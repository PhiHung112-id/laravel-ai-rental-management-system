<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        if (!session()->has('login_id')) {
            return redirect('/admin/login');
        }

        $users = User::orderBy('name','asc')->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function manage($id = null)
    {
        $user = $id
            ? User::find($id)
            : null;

        return view(
            'admin.users.manage',
            compact('user')
        );
    }

    public function save(Request $request)
    {
        try{

            $request->validate([
                'name' => 'required',
                'username' => 'required'
            ]);

            $user = $request->id
                ? User::find($request->id)
                : new User();

            if(!$user){
                return response('0');
            }

            $user->name = $request->name;
            $user->email = $request->username;
            $user->type = $request->type;

            if ($request->password) {
                $user->password = md5($request->password);
            }

            $user->save();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }


    public function delete($id)
    {
        try{

            $user = User::findOrFail($id);

            $user->delete();

            return response('1');

        }catch(\Throwable $e){

            return response($e->getMessage(),500);

        }
    }
}