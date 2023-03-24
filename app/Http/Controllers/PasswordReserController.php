<?php

namespace App\Http\Controllers;

use App\Models\PasswordReser;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordReserController extends Controller
{
    public function password_reset(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response([
                'message'=>'Email does Not exits'
            ]);
        }

        $token = Str::random(60);

        //    dump("http://127.0.0.1:3000/api/user/reset/" .$token);


        PasswordReser::create([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
        
        $email = $request->email;
       
        Mail::send('reset',['token'=>$token],function(Message $message)use($email){
            $message->subject('Reset Your Password');
            $message->to($email);
        });
       
        return response([
            'message'=>'send a token'
        ]);

        public function reset(Request $request ,$token)
        {
            $request->validate([
                'password'=>'required|confirmed',
            ]);

            $reset = PasswordReser::where('token',$token)->first();
            if(!rest){
                return response([
                    'message'=>'expired'
                ]);
            }

            $userrr = User::where('email',$reset->email)->first();

            $user->password = Hash::make($request->password);
            $user->save();


            //delete the token after reset
            PasswordReser::where('email',$user->email)->delete();


        }
    }

}
