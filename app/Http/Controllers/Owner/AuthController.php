<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\LoginRequest;
use App\Http\Requests\Owner\RegistrationRequest;
use App\Models\User;
use App\Models\UserInformation;
use App\Mail\OwnerRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Owner Registration Store Details Method

    public function registerStore(RegistrationRequest $request) {
        $user = User::create([
            'name' => $request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'type'=>"0",
        ]);
        $user->assignRole('owner');
        if($user):
            $userInformation = UserInformation::create([
              'user_id'  => $user->id,
              'phone'=> '+'.$request->input('country_code').$request->input('phone_number'),
              'term_conditions'=>$request->input('term_conditions')=='on'?"1":"0",
            ]);

            // Send registration confirmation email
            Mail::to($user->email)->send(new OwnerRegistration($user, $request->input('password')));
            Mail::to('support@rentforvacations.com')->send(new OwnerRegistration($user, $request->input('password')));

            return response()->json([
                'status'=>200,
                'msg'=>"Your registration successfully !, Please Now login",
                'url'=>route('frontend.log-in')
            ]) ;
        else:
            return response()->json([
                'status'=>500,
                'msg'=>"You not registerd ,Please try again sometimes "
            ]);
        endif;
    }

    public function login () {
        return view('owner.auth.login');
    }

    public function checkLogin(LoginRequest $request){
       $remember_me = $request->has('remember_me') ? true : false;
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)):
            if(Auth()->user()->getRoleNames()[0] =='owner'):
                return response()->json([
                    'status'=>200,
                    'msg'=>"Login Successfully. Please wait redirecting...",
                    'url'=>route('owner.dashboard'),
                ],200);
            else:
                Session::flush();
                Auth::logout();
                return response()->json([
                'status'=>401,
                'msg'=>'This Account Unauthorized!'
                ],401);
            endif;

        else:
            return response()->json([
                'status'=>401,
                'msg'=>'Your username and password are wrong. Please try again !'
            ],401);
        endif;
    }
}
