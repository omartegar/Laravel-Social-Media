<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

class LoginController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('pages.login');
        }

        return redirect()->action([HomeController::class, 'index']);
    }
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === null || $password === null) {
            return response()->json(['status' => 'failed', 'message' => 'Please fill all the inputs']);
        }

        try {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                session(['user_id' => Auth::user()->id]);
                return response()->json(['status' => 'success', 'message' => "logged in successfully"]);
            }
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid email/password', 'error' => $error]);
        }



        // try {
        //     $user = User::where('email', $email)->first();

        //     if (Hash::check($password, $user->password)) {
        //         session(['user_id' => $user->id]);
        //         return response()->json(['status' => 'success', 'message' => "logged in successfully"]);
        //     } else {
        //         return response()->json(['status' => 'failed', 'message' => 'Invalid email/password']);
        //     }
        // } catch (Exception $error) {
        //     return response()->json(['status' => 'failed', 'message' => 'invalid credentials!', 'error' => $error]);
        // }
    }

    public function destroy()
    {
        Auth::logout();
        return response()->json(['status' => 'success', 'message' => 'logged out successfully']);
    }
}
