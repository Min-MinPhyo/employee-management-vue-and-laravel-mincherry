<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        // if($request->has('search')){
        //     $users=User::where('username','like',"%{$request->search}%")->orWhere('email','like',"%{$request->search}%")->get();
        // }

        if($request->has('search')){
            $users=User::where('username','like',"%{$request->search}%")->orWhere('email','like',"%{$request->search}%")->get();

        }
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }
    public function store(UserStoreRequest $request)
    {

        User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('users.index')->with('message', 'User Create Successfully');
    }

    public function show(string $id)
    {
    }


    public function edit(User $user)
    {

        // $user=User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {

        $user->update(
            [
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email
            ]
        );

        return redirect()->route('users.index')->with('message', 'User Update Successfully');
    }


    public function destroy(User $user)
    {


        if (auth()->user()->id == $user->id) {
            return redirect()->route('users.index')->with('message', 'You are deleting yourself');
        }



        $user->delete();
        return redirect()->route('users.index')->with('message', 'User delete successfully !');
    }
}
