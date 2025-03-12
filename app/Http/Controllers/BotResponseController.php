<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotResponse;

class BotResponseController extends Controller
{
    public function index()
    {
        $responses = BotResponse::all();
        return view('bot_responses.index', compact('responses'));
    }

    public function create()
    {
        return view('bot_responses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_message' => 'required|unique:bot_responses',
            'bot_response' => 'required'
        ]);

        BotResponse::create($request->all());

        return redirect()->route('bot_responses.index')->with('success', 'Response added successfully!');
    }

    public function edit(BotResponse $botResponse)
    {
        return view('bot_responses.edit', compact('botResponse'));
    }

    public function update(Request $request, BotResponse $botResponse)
    {
        $request->validate([
            'user_message' => 'required|unique:bot_responses,user_message,' . $botResponse->id,
            'bot_response' => 'required'
        ]);

        $botResponse->update($request->all());

        return redirect()->route('bot_responses.index')->with('success', 'Response updated successfully!');
    }

    public function destroy(BotResponse $botResponse)
    {
        $botResponse->delete();

        return redirect()->route('bot_responses.index')->with('success', 'Response deleted successfully!');
    }
}
