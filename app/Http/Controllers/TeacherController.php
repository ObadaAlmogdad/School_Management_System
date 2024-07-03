<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    //register or creat a new teacher api
    public function addTeacher(Request $request): JsonResponse
    {
        //validation
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:teachers",/*|unique:myparents|unique:teachers|unique:users*/
            "password" => "required|confirmed",
            "gander" => "required",
            "phone" => "required"
        ]);
        //creat data
        $teacher = new Teacher();

        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->gander = $request->gander;
        $teacher->phone = $request->phone;

        $teacher->save();
        //send response

        return response()->json([
            "status"=> 1,
            "message"=>"Teacher create successfully"
        ], 200);
    }
    //login api
    public function login(Request $request): JsonResponse{
        //validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $teacher = Teacher::where("email", "=" ,$request->email)->first();

        if (isset($teacher->id)){

            if (Hash::check($request->password , $teacher->password)){

                $token =$teacher->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status"=> 1,
                    "message"=>"teacher logged in successfully",
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
                "message"=>"teacher not found"
            ], 404);
        }
    }
    //show a profile for student api
    public function profile(){

    }
    //logout api
    public function logout(): JsonResponse
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "teacher logged out successfully"
        ], 200);
    }
}
