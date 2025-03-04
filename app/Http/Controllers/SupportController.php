<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SupportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAgent()) {
            $conversations = Conversation::where('agent_id', $user->id)
                ->orWhereNull('agent_id')
                ->with('user', 'messages')
                ->get();
        } else {
            $conversations = $user->conversations()->with('agent', 'messages')->get();
        }
        return view('support.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorizeConversation($conversation);
        $conversation->load('messages.user');
        return view('support.show', compact('conversation'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $this->authorizeConversation($conversation);
        $request->validate(['content' => 'required|string|max:1000']);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('support.show', $conversation);
    }

    public function startConversation()
    {
        $conversation = Conversation::create(['user_id' => Auth::id()]);
        return redirect()->route('support.show', $conversation);
    }

    public function assignAgent(Conversation $conversation)
    {
        if (Auth::user()->isAgent() && !$conversation->agent_id) {
            $conversation->update(['agent_id' => Auth::id()]);
        }
        return redirect()->route('support.show', $conversation);
    }

    private function authorizeConversation(Conversation $conversation)
    {
        $user = Auth::user();
        abort_unless(
            $user->isAgent() || $conversation->user_id === $user->id,
            403,
            'You are not authorized to view this conversation.'
        );
    }
}
