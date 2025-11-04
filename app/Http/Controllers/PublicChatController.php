<?php

namespace App\Http\Controllers;

use App\Models\PublicChat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (!Auth::check()) {
            return view('pages.login');
        }

        // $mine = User::find(Auth()->user()->id);

        $data = PublicChat::with('user')->get();
        return view('pages.public-chat', ['data' => $data, 'mine' => Auth::user()]);
    }

    public function index_messages()
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'failed', 'message' => "You are not logged in!"]);
        }

        $data = PublicChat::with('user')->get();
        return ['data' => $data];
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
            return response()->json(['status' => 'failed', 'message' => 'you are not logged in']);
        }


        try {
            $message = $request->input('message');

            PublicChat::create([
                "sender_id" => Auth::user()->id,
                "message_text" => $message
            ]);

            return response()->json(['status' => 'success', 'message' => 'message sent successfully to public chat']);
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
    public function destroy(string $id)
    {
        //
    }
}
