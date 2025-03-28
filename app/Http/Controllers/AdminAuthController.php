<?php

namespace App\Http\Controllers;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function register(Request $request){
        $errors=Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "email"=>"required|email|max:255",
            "password"=>"required|string|min:6|confirmed",
        ]);

        if($errors->fails()){
            return response()->json([
                "error"=>$errors->errors()
            ],301);
        }

        $password=bcrypt($request->password);

        $access_token=Str::random(100);
        
        Admin::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$password,
            "access_token"=>$access_token,
        ]);

        return response()->json([
            "msg" => "Register successfully",
            "access_token" => $access_token
        ], 200);
    }
    public function login(Request $request){
        $errors=Validator::make($request->all(),[
            "email"=>"required|email|max:255",
            "password"=>"required|string|min:6",
        ]);

        if($errors->fails()){
            return response()->json([
                "error"=>$errors->errors()
            ],301);
        }
        $user=Admin::where("email",$request->email)->first();
        if(!$user){
            return response()->json([
                "msg" => "Email Not Correct",
            ], 301);
        }
        $valid=Hash::check($request->password,$user->password);

        if($valid == true){
            $access_token=Str::random(100);
            $user->update([
                "access_token"=>$access_token
            ]);
            return response()->json([
                "msg" => "You Login Successfully",
                "access_token" => $access_token
            ], 301);
        }else{
            return response()->json([
                "msg" => "Not Correct",
            ], 301);
        }
    }
    public function logout(Request $request) {
        $access_token = $request->header("access_token") 
                        ?? $request->header("Authorization") 
                        ?? $request->bearerToken() 
                        ?? $request->input('access_token');
        
        if (!$access_token) {
            return response()->json(["msg" => "Access token is missing"], 401);
        }
    
        $access_token = str_replace('Bearer ', '', $access_token);
        
        $user = Admin::where("access_token", $access_token)->first();
        
        if (!$user) {
            return response()->json(["msg" => "Invalid or expired access token"], 401);
        }
        
        $user->update(["access_token" => null]);
        
        return response()->json(["msg" => "You have logged out successfully"], 200);
    }
}
