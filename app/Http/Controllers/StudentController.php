<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //register or creat a new student api
    public function addStudent(Request $request): \Illuminate\Http\JsonResponse
    {
        //validation
    $request->validate([
        "first_name" => "required",
        "last_name" => "required",
        "father_name" => "required",
        "mother_name" => "required",
        "email" => "required|email|unique:students",/*|unique:myparents|unique:teachers|unique:users*/
        "password" => "required|confirmed",
        "gander" => "required",
        "birthday" => "required"
    ]);
        //creat data
    $student = new Student();

    $student->first_name = $request->first_name;
    $student->last_name = $request->last_name;
    $student->father_name = $request->father_name;
    $student->mother_name = $request->mother_name;
    $student->email = $request->email;
    $student->password = Hash::make($request->password);
    $student->gander = $request->gander;
    $student->birthday = $request->birthday;

    $student->save();
        //send response

        return response()->json([
            "status"=> 1,
            "message"=>"Student create successfully"
        ], 200);
    }
    //login api
    public function login(Request $request): \Illuminate\Http\JsonResponse{
        //validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $student = Student::where("email", "=" ,$request->email)->first();

        if (isset($student->id)){

            if (Hash::check($request->password , $student->password)){

                $token =$student->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status"=> 1,
                    "message"=>"Student logged in successfully",
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
                "message"=>"Student not found"
            ], 404);
        }
    }
    //show a profile for student api
    public function profile(){

    }
    //logout api
    public function logout(): \Illuminate\Http\JsonResponse
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "student logged out successfully"
        ], 200);
    }
}
