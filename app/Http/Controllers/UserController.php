<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\User;

class UserController extends Controller
{

    #############REGISTER###########

    public function register(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('KarAmoozi')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }



    ###########LOGIN##########
    
    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('KarAmoozi')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }



    ############LOG OUT##############
    
    public function logout (Request $request){

        $token= $request->user()->token();
        $token->revoke();

        return response()->json('You have been successfully logged out ');
    }

}
