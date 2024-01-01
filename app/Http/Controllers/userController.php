<?php

namespace App\Http\Controllers;

use App\Helper\JWTHelper;
use App\Mail\OTPMail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    public function registration(Request $request)
    {

        try {

            User::create($request->input());
            return response()->json(['status' => 'success', 'message' => 'User Registration Successfully']);
        } catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function login(Request $request)
    {

        try {
            $user = User::where($request->input())->select('id')->first();
            $userId = $user->id;

            if ($userId > 0) {
                $token = JWTHelper::CreateToken($request->input('email'), $userId);
                return response()->json(['status' => 'success', 'message' => 'User Login Successfully'])->cookie('token', $token, time() + 60 * 60);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No user found']);
            }
        } catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function sendOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);

        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            //send otp

            Mail::to($email)->send(new OTPMail($otp));

            //update table

            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json(['status' => 'success', 'message' => '4 degit OTP code has been sent to your email.']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized']);
        }
    }

    function verifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if ($count == 1) {

            //update otp

            User::where('email', '=', $email)->update(['otp' => '']);

            // token create

            $token = JWTHelper::CreateTokenForSetPassword($email);

            return response()->json(['status' => 'success', 'message' => 'OTP verification successfully'])->cookie('token', $token, time() + 60 * 5);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized']);
        }
    }

    function resetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', '=', $email)->update(['password' => $password]);

            return response()->json(['status' => 'success', 'message' => 'Password reset successfully. ']);
        } catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized']);
        }
    }
    function profile(Request $request)
    {
        $userID = $request->header('id');
        return User::where('id', $userID)->first();
    }


    function logout()
    {
        return redirect('/login')->cookie('token', '', time() - 60 * 60);
    }
}
