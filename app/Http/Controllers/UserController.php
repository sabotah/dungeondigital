<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    { 
        if (request('email') == $user->email) {
            $this->validate(request(), [
                'name' => 'required'
            ]);
        }
        else {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email|unique:users'
            ]);            
        }


        $authuser = \Auth::user();
        // if ($user->id == $authuser->id) {
            $user->name = request('name');
            $user->email = request('email');
            $maillist = false;
            if (request('maillist')) {
                $maillist = true;
            }

            $user->maillist = $maillist;

            $user->save();
        // }
        // exit;
        return back()->with('status','Details Updated!');
    }
}