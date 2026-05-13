<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInformation;
use Auth;
use Session;
use App\Http\Requests\Owner\ChangePasswordRequest;
use Hash;
use App\Models\Property;

class HomeController extends Controller
{
    public function dashboard(){
        $properties = Property::where('user_id',Auth()->user()->id)->get();
        return view('owner.dashboard',compact('properties'));
    }

    public function myProfile (){
        return view('owner.my-profile');
    }

    public function editProfile(Request $request) {
        $user = User::where('id',Auth()->user()->id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email_address'),
        ]);
        if($user):
            UserInformation::updateOrCreate(
                ['user_id'=>Auth()->user()->id],
                [
                    'secondary_email'=>$request->input('alternate_email_address'),
                    'phone'=>$request->input('phone'),
                    'alternate_phone'=>$request->input('alternate_phone'),
                    'about_you'=>$request->input('notes')
                ]
            );

            return response()->json([
                'status'=>200,
                'msg'=>"Your Profile Update Successfully!"
            ],200);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>"Your Profile Not Updated, Please try again"
            ],500);
        endif;
    }

    public function logOut(){
        Session::flush();
        Auth::logout();
        return response()->json([
            'status'=>200,
            'msg'=>"Your Account Has been Logout,Please wait redirecting...",
            'url'=>route('frontend.index')
        ]);
    }

    public function profilePhoto(Request $request) {
        if(!$request->hasFile('profile_image')):
            return response()->json([
                'status'=>422,
                'msg'=>"Please select a photo before uploading."
            ]);
        endif;
        $destinationPath = storage_path('app/public/upload/profile_image/');
        if(!file_exists($destinationPath)):
            mkdir($destinationPath, 0775, true);
        endif;
        $profile_iamge = time().uniqid().".".$request->file('profile_image')->getClientOriginalExtension();
        $request->file('profile_image')->move($destinationPath,$profile_iamge);
        $userProfile = UserInformation::updateOrCreate(
            ['user_id'=>Auth()->user()->id],
            ['profile_pic'=>$profile_iamge]
        );
        if($userProfile):
            return response()->json([
                'status'=>200,
                'msg'=>"Your profile Updated successfully",
            ]);
        else:
             return response()->json([
                'status'=>500,
                'msg'=>"Your profile Not Updated,Please try again",
            ]);
        endif;
    }

    public function ownerAddress(Request $request) {
        $ownerAddress = UserInformation::updateOrCreate(
            ['user_id'=>Auth()->user()->id],
            [
                'address'=>$request->input('street_address'),
                'city'=>$request->input('city'),
                'state'=>$request->input('state'),
                'country'=>$request->input('country'),
                'zipcode'=>$request->input('zip_code'),
            ]
        );
        if($ownerAddress):
            return response()->json([
                'status'=>200,
                'msg'=>"Your Address Updated SuccessFully !"
            ]);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>'Your Address Not Updated, Please try again'
            ]);
        endif;
    }

    public function changePassword(ChangePasswordRequest $request) {
        $auth = Auth::user();
        // The passwords matches
        if (!Hash::check($request->input('old_password'), $auth->password))
        {
            return response()->json([
                'status'=>500,
                'msg'=>"Old Password does not match."
            ]);
        }

        $passwordUpdate = User::where('id',Auth::user()->id)->update([
            'password'=>Hash::make($request->input('new_password')),
        ]);
        
        if($passwordUpdate):
            Session::flush();
            Auth::logout();
            return response()->json([
                'status'=>200,
                'msg'=>"Your Password Updated SuccessFully,Please Wait Redirecting",
                'url'=>route('frontend.index')
            ]);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>"Your Password Not Updated , Please try again.."
            ]);
        endif;

    
    }
}
