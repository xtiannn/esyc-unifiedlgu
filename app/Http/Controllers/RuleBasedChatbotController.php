<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuleBasedChatbotController extends Controller
{
    public function chatbot()
    {
        return view('chatbot.chatbot');
    }
    public function chat(Request $request)
    {
        $message = strtolower($request->message);

        // Predefined responses
        $responses = [
            'hello' => 'Hi there! How can I assist you today?',
            'hi' => 'Hello! How can I help?',
            'how are you' => 'I am just a bot, but I am doing great! How about you?',
            'help' => 'Sure! I can help you with common questions like account issues, payments, and system guidance.',
            'payment' => 'For payment-related queries, please check your account settings or contact support.',
            'account' => 'You can update your account settings in the profile section.',
            'thank you' => 'You\'re welcome! Let me know if you need anything else.',
            'bye' => 'Goodbye! Have a great day!',
        ];

        // Default response if no match is found
        $reply = 'I am not sure how to respond to that. Can you rephrase?';

        // Check for keyword match
        foreach ($responses as $key => $response) {
            if (strpos($message, $key) !== false) {
                $reply = $response;
                break;
            }
        }

        return response()->json(['reply' => $reply]);
    }
}
