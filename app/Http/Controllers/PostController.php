<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            return view('pages.postcreate');
        } else {
            return view('pages.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['status' => 'failed', 'message' => "Please login first"]);
        }

        $post_content = $request->input('textarea');

        if ($post_content === null) {
            return response()->json(['status' => 'failed', 'message' => "Cannot create an empty post"]);
        }

        Post::create([
            "user_id" => Auth::user()->id,
            "post_content" => $post_content
        ]);

        return response()->json(['status' => 'success', 'message' => 'Post created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        try {
            $postId = $request->input('postid');
            Post::find($postId)->delete();
            return response()->json(['status' => 'success', 'message' => "Post deleted successfully"]);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'message' => 'Cannot delete this post', 'error' => $error]);
        }
    }
}
