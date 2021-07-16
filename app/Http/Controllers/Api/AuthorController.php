<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //Register Method - Api
    public function register(Request $request)
    {
        //validate
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'password' => 'required|confirmed',
            'phone_no' => 'required'
        ]);

        //create data
        $author = new Author();

        $author->name = $request->name;
        $author->email = $request->email;
        $author->password = bcrypt($request->password);
        $author->phone_no = $request->phone_no;
        $author->save();

        //send response
        return response()->json([
            'status' => 1,
            'message' => 'Author Created Successfully'
        ]);
    }

    //Login Method - Api
    public function login(Request $request)
    {
        //validate
        $login_data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        //validate auhtor data
        if (!auth()->attempt($login_data)) {

            return response()->json([
                'status' => 'false',
                'message' => 'invalid credentials'
            ]);
        }
        //token
        $token = auth()->user()->createToken('auth_token');

        //send response
        return response()->json([
            'status' => true,
            'message' => 'author logged in successfully!',
            'access_token' => $token
        ]);
    }

    //Profile Method - Api
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Author Profile Data',
            'data' => $user_data
        ]);
    }

    //Logout Method - Api
    public function logout(Request $request)
    {
        //get token value
        $token = $request->user()->token();
        //revoke this token value
        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'author logged out successfully'
        ]);
    }
}
