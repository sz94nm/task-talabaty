<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return view('dashboard.partial.users.show');
        }
    }

    public function getUsers()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::all();
            return Response::json($users);
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return $user = User::where('id', $request->id)->delete();
            return $user->delete();
        }
    }

    public function edit(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $user = User::find($request->id);
            {
                $data = [
                    "user" => $user
                ];
                return view('dashboard.partial.users.update', $data);
            }
        }
    }

    public function create()
    {
        if (Auth::user()->role == 'admin') {

            return view('dashboard.partial.users.create');
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required'],
        ];
        $data = $this->validate($request, $rules);
        if (Auth::user()->role == 'admin') {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);
        }

        return view('dashboard.partial.users.show');
    }

    public function update(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id],
                'password' => ['string', 'min:8', 'confirmed'],
                'role' => ['required'],
            ];
            $data = $this->validate($request, $rules);
            $user = User::find($request->id);

            {
                $user->update($data);
            }

            return view('dashboard.partial.users.show');
        }
    }

}
