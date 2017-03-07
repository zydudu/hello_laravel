<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
       $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

       $credentials = [
           'email'    => $request->email,
           'password' => $request->password,
       ];       
//var_dump($credentials);die;
       if (Auth::attempt($credentials)) {
           session()->flash('success', 'Welcome!');
           return redirect()->route('users.show', [Auth::user()]);
       } else {
           session()->flash('danger', 'Incorrect username or password.');
           return redirect()->back();
       }
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', 'You have sign out successfully!');
        return redirect('login');
    }

}
