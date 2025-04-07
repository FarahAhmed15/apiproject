<?php

namespace App\Http\Controllers;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ServiceProviderAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:200",
            "email" => "required|email|max:200|unique:service_providers,email",
            "password" => "required|string|min:6|confirmed",
            "experience_years" => "required|string",
            "category_id" => "required|exists:categories,id",
            "services" => "required|array|min:1",
            "services.*" => "exists:services,id",
            "prices" => "required|array|min:1",
            "prices.*" => "numeric|min:50|max:1000",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $access_token = Str::random(100);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['access_token'] = $access_token;

        $provider = ServiceProvider::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
            "experience_years" => $data['experience_years'],
            "category_id" => $data['category_id'],
            "access_token" => $access_token,
        ]);

        $syncData = [];
        foreach ($request->services as $index => $serviceId) {
            $syncData[$serviceId] = ['price' => $request->prices[$index]];
        }
        $provider->services()->sync($syncData);

        return response()->json([
            'status' => true,
            'message' => 'Service provider registered successfully. Wait for admin approval.',
            'data' => [
                'id' => $provider->id,
                'name' => $provider->name,
                'email' => $provider->email,
                'access_token' => $access_token
            ]
        ], 201);
    }
    public function login(Request $request){
        $errors=Validator::make($request->all(),[
            "email"=>"required|email|max:255",
            "password"=>"required|string|min:6",
        ]);

        if($errors->fails()){
            return response()->json([
                "error"=>$errors->errors()
            ],401);
        }
        $user=ServiceProvider::where("email",$request->email)->first();
        if(!$user){
            return response()->json([
                "msg" => "Email Not Correct",
            ], 401);
        }
        $valid=Hash::check($request->password,$user->password);

        if($valid == true){
            $access_token=Str::random(100);
            $user->update([
                "access_token"=>$access_token
            ]);
            return response()->json([
                "msg" => "You Login Successfully",
                "access_token" => $access_token,
                "user" => $user
            ], 200);
        }else{
            return response()->json([
                "msg" => "Not Correct",
            ], 401);
        }
    }
}
