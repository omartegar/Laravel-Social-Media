<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('pages.home');
        }

        return view('pages.signup');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmpassword');
        $age = $request->input('age');
        $phone_number = $request->input('phone_number');

        if ($name === null || $email === null || $password === null || $confirmPassword === null || $age === null || $phone_number === null) {
            return response()->json(['status' => 'failed', 'message' => "Please fill all the inputs"]);
        }

        if ($password !== $confirmPassword) {
            return response()->json(['status' => 'failed', 'message' => 'passwords doesn\'t match']);
        }

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('images', 'public');
        } else {
            return response()->json(['status' => 'failed', 'message' => "You should upload a profile picture"]);
        }


        try {
            User::create([
                "name" => $name,
                "email" => $email,
                "password" => bcrypt($password),
                "age" => $age,
                "phone_number" => $phone_number,
                "image_url" => $path
            ]);

            return response()->json(['status' => 'success', 'message' => 'Account Created Successfully']);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'message' => "This email/phone may be used by another user.", 'error' => $error]);
        }
    }
}
