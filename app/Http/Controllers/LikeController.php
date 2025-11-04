<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use Exception;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            response()->json(['status' => 'Failed', 'message' => "You are not logged in!"]);
        }

        if ($request->input('post_id') === null) {
            response()->json(['status' => 'failed', 'message' => 'The "post_id" to be liked is not filled with the request!']);
        }

        $post_id = $request->input('post_id');

        try {
            Like::create([
                "user_id" => Auth::user()->id,
                "post_id" => $post_id
            ]);

            return response()->json(['status' => 'success', 'message' => 'post liked successfully']);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'error' => $error]);
        }
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
        if (!Auth::check()) {
            response()->json(['status' => 'Failed', 'message' => "You are not logged in!"]);
        }

        if ($request->input('post_id') === null) {
            response()->json(['status' => 'failed', 'message' => 'The "post_id" to be liked is not filled with the request!']);
        }

        $post_id = $request->input('post_id');

        try {
            Like::where('user_id', Auth::user()->id)->where('post_id', $post_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Post deleted successfully']);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'error' => $error]);
        }
    }
}
