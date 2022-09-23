<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\City;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    public function index(){
        return inertia(
            'Auth/Login',
            [
                'title' => appTitle()
            ]
            );
    }

    public function auth(LoginRequest $request){
        $credentials    = $request->only('email', 'password');
        // $remember       = $remember != true ? false : $remember;
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }else {
            return redirect()->route('auth.login')->withErrors('Uknown Username Or Password');
        }
    }

    public function register(City $city){
        $responseCity = $city->all();
        return inertia(
            'Auth/Register',
            [
                'title' => appTitle(),
                'data' => [
                    'city' => $responseCity
                ]
            ]
            );
    }

    public function regist(AuthRegisterRequest $request){
        
        // iniate model
        $user = new User;
        $profile = new Profile;

        // user
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // profile
        $profile->user_id = $user->id;
        $profile->first_name = $request->fname;
        $profile->last_name = $request->lname;
        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->zip_code = $request->zip_code;
        $profile->phone_number = PhoneNumber::make($request->phone['number'], $request->phone['country'])->formatE164();
        $profile->country = $request->phone['country'];
        $profile->save();

        return redirect()->route('auth.login')->with('success','You can sign in using account you just registered!');
    }

    public function logout(){
        Auth::logout();
        session()->forget('cart');
        return redirect()->route('auth.login');
    }
}