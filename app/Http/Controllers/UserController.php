<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends Controller
{

    //register user
    public function register(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed',
            'tc'=>'required',
        ]);

        if(User::where('email',$request->email)->first()){
            return response([
                'message'=>'Already Taken'
            ]);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'tc'=>json_decode($request->tc),
        ]);

        $token =  $user->createToken($request->email)->plainTextToken;
        
        return response([
            'token' => $token,
            'message'=> 'sucess'
        ]);
  
    }

    // login user
    public function login(Request $request)
        {
            $request->validate([
                'email'=>'required',
                'password'=>'required'
            ]);

            $user = User::where('email',$request->email)->first();
            if($user && hash::check($request->password,$user->password)){

                $token = $user->createToken($request->email)->plainTextToken;
                    return response([
                        'token is' => $token,
                        'message'=>'login successfully'
                    ]);
            };
            return response([
                'message'=>'login failed',
                'status'=>'login failed'
            ]);
        }

        //logout user

        public function logout(Request $request)
        {
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });

            return response([
                'message'=>'log out',
                
            ]);
        }
// get data of logged user
        public function logeduser(Request $request)
        {
            $loged_user = auth()->user();

            return response([
                'user'=> $loged_user,
                'message'=>'loged user',
                
            ]);
        }

//chnage password
        public function changepassword(Request $request)
        {
            // $request->validate([
            //     'password'=>'required|confirmed'
            // ]);
            // $logeduser = Auth::user();
            // $logeduser->update([
            //     'password' => Hash::make($request->password),
            // ]);
            $request = Request::createFromGlobals();
            $validatedData = $request->validate([
                'password' => 'required|confirmed',
            ]);
            $logeduser = Auth::user();

            $logeduser->update([
                'password' => Hash::make($validatedData['password']),
            ]);

            return response([
                'message'=>'password change succesfully',
             
            ]);
        }
}
