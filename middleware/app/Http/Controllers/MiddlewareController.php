<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class MiddlewareController extends Controller
{
    public function login(){
        return view('login');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with([
            'message' => 'Cuts Success'
        ]);
    }

    public function register(){
        return view('register');
    }

    public function postLogin(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('home.home')->with([
                'message' => 'Success'
            ]);
        }else {
            return redirect()->back()->with([
                'message' => 'You are not Super Admin'
            ]);
        }
    }

    public function postRegister(Request $request){
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $userId = $user->id;

        Role::create([
            'role' => $request->role,
            'id_user' => $userId,
        ]);

        return redirect()->route('login')->with([
            'message' => 'Register Success'
        ]);
    }

    public function home(){
        return view('home');
    }

    public function forgot(){
        return view('forget-password');
    }

    public function postForgot(Request $request){
        $user = User::where('email', '=' , $request->email)->first();
        if($user){
            $user->remember_token = Str::random(40);
            $user->save();

            $email_to = $user->email;
            Mail::send('email', compact('user'), function($message) use ($email_to){
                $message->from('caygame12345hyy@gmail.com', 'Tuan Clothing');
                $message->to($email_to, $email_to);
                $message->subject('Forgot Notification');
            });

            return redirect()->back()->with([
                'message' => 'Email Success'
            ]);
        }else{
            return redirect()->back()->with([
                'message' => 'Email not is incorrect'
            ]);
        }
    }

    public function resetPass($token, Request $request){
        $user = User::where('remember_token', '=' , $token)->first();
        return view('reset', compact('user'));
    }

    public function resetPostPass(Request $request, $id){
        $user = User::where('id', '=' , $id)->first();

        if($request->passOld == $request->password){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('login')->with([
                'message' => 'Change Password Success, Plaese Login'
            ]);
        }else{
            return redirect()->back()->with([
                'message' => 'New Password does Not Match'
            ]);
        }
    }
}
