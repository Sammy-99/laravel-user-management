<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;

class LogIn extends Controller
{
    public function checkUserAuth(Request $req)
    {
        $rules = [
            'email' => 'required|min:5|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'password' => 'required|min:6'
        ];
    
        $customMessages = [
            'email.required' => 'Please enter your email',
            'password.required' => 'Please enter your password'
        ];

        $this->validate($req, $rules, $customMessages);

        if(Auth::attempt(['email' => $req->email, 'password' => $req->password, 'status' => 1])){
            $req->session()->put('email', $req->email);
            
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with('error', 'Credentials not matched.');
        }
    }

}
