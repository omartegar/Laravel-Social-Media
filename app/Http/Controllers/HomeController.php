<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use Exception;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('pages.login');
        }

        $users = User::all();
        $posts = Post::orderBy('created_at', 'desc')->with('user')->get();
        $LikesFound = Like::where('user_id', Auth::user()->id)->get();


        return view('pages.home', ['users' => $users, 'mine' => Auth::user(), 'posts' => $posts, 'likes_by_me' => $LikesFound]);
    }
}
