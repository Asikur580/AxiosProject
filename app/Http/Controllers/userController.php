<?php

namespace App\Http\Controllers;

use App\Helper\JWTHelper;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;

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
                return response()->json(['status' => 'success', 'message' => 'User Login Successfully'])->cookie('token',$token,time()+60*60);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No user found']);
            }
        } catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function profile(Request $request){
        $userID=$request->header('id');
        return User::where('id',$userID)->first();
    }


    function logout(){
        return redirect('/login')->cookie('token','',time()-60*60);
    }
}
