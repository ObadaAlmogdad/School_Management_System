<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //admin register api
    public function register(Request $request): JsonResponse
    {
        //validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",/*|unique:myparents|unique:teachers|unique:users*/
            "password" => "required|confirmed|max:20|min:8"
        ]);
        //creat data
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        //send response

        return response()->json([
            "status"=> 1,
            "message"=>"ADMIN create successfully"
        ], 200);
    }
    //login api
    public function login(Request $request): JsonResponse
    {

        //validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", "=" ,$request->email)->first();

        if (isset($user->id)){

            if (Hash::check($request->password , $user->password)){

                $token =$user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status"=> 1,
                    "message"=>"admin logged in successfully",
                    "access_token"=> $token
                ], 200);

            }else{
                return response()->json([
                    "status"=> 0,
                    "message"=>"password did not match"
                ], 404);
            }

        }else{
            return response()->json([
                "status"=> 0,
                "message"=>"admin not found"
            ], 404);
        }
    }
    //show a profile for admin api
    public function profile(): JsonResponse
    {
        return response()->json([
            "status" => 200,
            "message" => "User profile data",
            "data" => auth()->user()
        ], 200);

    }
    //logout api
    public function logout(): JsonResponse
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "admin logged out successfully"
        ], 200);
    }


}
