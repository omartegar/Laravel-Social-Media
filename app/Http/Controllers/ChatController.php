<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!Auth::check()) {
            return view('pages.login');
        }
        if (!session('receiver_id')) {
            return view('pages.home');
        }


        $chat_with_users = Chat::where(function ($query) {
            $query->where('sender_id', Auth::user()->id)
                ->orWhere('receiver_id', Auth::user()->id);
        })
            ->where(function ($query) {
                $query->where('sender_id', session('receiver_id'))
                    ->orWhere('receiver_id', session('receiver_id'));
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.chat', ['receiver_id' => session('receiver_id'), 'mine' => Auth::user(), 'chat_with_users' => $chat_with_users]);
    }

    public function index_messages(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'failed', 'message' => 'You are not logged in.']);
        }
        if (!session('receiver_id')) {
            return response()->json(['status' => 'Failed', 'message' => "No receiver_id session key found with the request!"]);
        }

        $chat_with_users = Chat::where(function ($query) {
            $query->where('sender_id', Auth::user()->id)
                ->orWhere('receiver_id', Auth::user()->id);
        })
            ->where(function ($query) {
                $query->where('sender_id', session('receiver_id'))
                    ->orWhere('receiver_id', session('receiver_id'));
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();


        return response()->json(['status' => 'success', 'receiver_id' => session('receiver_id'), 'chat_with_users' => $chat_with_users]);
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
            return response()->json(['status' => 'failed', 'message' => 'You are not logged in!']);
        }

        if (!session('receiver_id')) {
            return response()->json(['status' => "failed", 'message' => 'There is no receiver_id in session!']);
        }

        if ($request->input('message_content') === null) {
            return response()->json(['status' => 'failed', 'message' => 'There is no message_content typed ']);
        }


        $receiver_id = session('receiver_id');
        $message_content = $request->input('message_content');

        try {
            Chat::create([
                "sender_id" => Auth::user()->id,
                "receiver_id" => $receiver_id,
                "message_content" => $message_content
            ]);

            return response()->json(['status' => 'success', 'message' => 'message sent successfully']);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'message' => "failed to send the message"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $receiver_id = $request->input('receiver_id');
            session(['receiver_id' => $receiver_id]);

            return response()->json(['status' => 'success', 'message' => 'Receiver is ready to chat page']);
        } catch (Exception $error) {
            return response()->json(['status' => 'failed', 'message' => 'failed to preparing your received_id session']);
        }
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
