<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->get();
        return response([
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'type' => 'required|string|max:15',
            'bio' => 'nullable|string|max:60',
            'photo' => 'nullable|string|max:60'
        ]);

        $user = new User;
        $user->name = ucwords($request->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = ucfirst($request->type);
        $user->bio = ucfirst($request->bio);
        $request->photo ? $request->photo : false;
        $user->save();

        return response([]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response([]);
    }
}
