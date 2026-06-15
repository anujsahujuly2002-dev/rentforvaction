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
    public function registerStore(RegistrationRequest $request)
    {
        $user = User::create([
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'password'    => Hash::make($request->input('password')),
            'type'        => "0",
            'is_approved' => 0,
        ]);
        $user->assignRole('owner');

        if ($user) {
            UserInformation::create([
                'user_id'         => $user->id,
                'phone'           => '+' . $request->input('country_code') . $request->input('phone_number'),
                'term_conditions' => $request->input('term_conditions') == 'on' ? "1" : "0",
            ]);

            Mail::to($user->email)->send(new OwnerRegistration($user, $request->input('password')));
            Mail::to('support@rentforvacations.com')->send(new OwnerRegistration($user, $request->input('password')));

            return response()->json([
                'status' => 200,
                'msg'    => 'Registration successful! Your account is pending admin approval. You will be notified once approved.',
                'url'    => route('owner.login'),
            ]);
        }

        return response()->json([
            'status' => 500,
            'msg'    => 'Registration failed. Please try again.',
        ]);
    }

    public function login()
    {
        return view('owner.auth.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        $remember_me = $request->has('remember_me');

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = Auth::user();

            if ($user->getRoleNames()[0] !== 'owner') {
                Session::flush();
                Auth::logout();
                return response()->json([
                    'status' => 401,
                    'msg'    => 'This account is not authorized.',
                ], 401);
            }

            if ($user->is_approved != 1) {
                Session::flush();
                Auth::logout();
                return response()->json([
                    'status' => 401,
                    'msg'    => 'Your account is pending admin approval. Please wait for approval before logging in.',
                ], 401);
            }

            if ($user->status == 1) {
                Session::flush();
                Auth::logout();
                return response()->json([
                    'status' => 401,
                    'msg'    => 'Your account has been blocked. Please contact support.',
                ], 401);
            }

            return response()->json([
                'status' => 200,
                'msg'    => 'Login successful. Please wait, redirecting...',
                'url'    => route('owner.dashboard'),
            ]);
        }

        return response()->json([
            'status' => 401,
            'msg'    => 'Incorrect email or password. Please try again.',
        ], 401);
    }
}
