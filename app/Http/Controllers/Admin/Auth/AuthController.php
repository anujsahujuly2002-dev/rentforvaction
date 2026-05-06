<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Carbon\Carbon;
use Mail;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function doLogin(LoginRequest $request) {
        $remember_me = $request->has('remember_me') ? true : false; 
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)):
           return response()->json([
            'msg'=>"Login Successfully. Please wait redirecting...",
            'url'=>route('admin.dashboard'),
           ],200);
        else:
            return response()->json([
                'msg'=>'Your username and password are wrong. Please try again !'
            ],401);
        endif;
    }


    public function forgetPassword() {
        return view('admin.auth.forget-password');
    }

    public function sendForgetPasswordLink(Request $request) {
        $rule = [
            'email' => 'required|email|exists:users',
        ];
        $validator = \Validator::make($request->all(),$rule);
        if($validator->fails()):
            return response()->json([
                'status'=>422,
                'errors'=>$validator->errors()
            ],422);
        else:
            $token = \Str::random(64);
            \DB::table('password_reset_tokens')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
            $mail=Mail::send('email-template.forget-password', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
          if($mail):
            return response()->json([
                'status'=>200,
                'msg'=>'We have e-mailed your password reset link!'
            ],200);
          else:
            return response()->json([
                'status'=>200,
                'msg'=>'Internal Server Error'
            ],500);
          endif;
        endif;
    }

    public function resetPassword($token){
        return view('admin.auth.reset-password',compact('token'));
    }

    public function passwordReset(Request $request){
        $rule = [
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ];
        $validator = \Validator::make($request->all(),$rule);
        if($validator->fails()):
            return response()->json([
                'status'=>422,
                'errors'=>$validator->errors()
            ],422);
        else:
            $checkToken = \DB::table('password_reset_tokens')->where('token',$request->input('token'))->first();
            if(!$checkToken):
                return response()->json([
                    'status'=>500,
                    'msg'=>"Invalid Token Please try again"
                ],500);
            else:
                $user = User::where('email',$checkToken->email)->update([
                    'password'=>\Hash::make($request->input('password'))
                ]);
                if($user):
                   \DB::table('password_reset_tokens')->where('token',$request->input('token'))->delete();
                    return response()->json([
                        'status'=>200,
                        'msg'=>"Your password has been changed!"
                    ], 200);
                else:
                    return response()->json([
                        'status'=>500,
                        'msg'=>"Your password has been not changed"
                    ], 500);
                endif;
            endif;
        endif;
    }
}
