<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\BotResponse;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return view('messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $userMessage = strtolower(trim($request->input('message')));

        // Fetch the bot response from database
        $botResponse = BotResponse::whereRaw('LOWER(user_message) = ?', [$userMessage])->value('bot_response');

        // If no response is found in the database, return a default response
        if (!$botResponse) {
            $botResponse = "I'm not quite sure I understand. Would you like to chat with an admin for further assistance, or can you try rephrasing your question?";

        }

        // Save the chat history
        $message = Message::create([
            'user_message' => $userMessage,
            'bot_response' => $botResponse
        ]);

        return response()->json($message);
    }


    public function connectToAdmin()
    {
        $admin = User::where('role', 'admin')->where('is_online', true)->first();

        if ($admin) {
            return response()->json([
                'status' => 'success',
                'message' => "You are now connected to Admin {$admin->name}.",
                'admin_id' => $admin->id
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "No admins are available right now. Please try again later."
            ]);
        }
    }
}
