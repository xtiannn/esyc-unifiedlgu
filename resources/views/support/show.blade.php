<x-app-layout>
    <style>
        .chat-box {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
        }

        .message .sender {
            font-weight: bold;
        }

        .message .time {
            font-size: 0.8em;
            color: #6c757d;
        }

        .message.mine {
            text-align: right;
        }

        .message.mine .sender {
            color: #28a745;
        }
    </style>
    <div class="container mt-4">
        <h2>Chat with
            {{ auth()->user()->isAgent() ? $conversation->user->name : ($conversation->agent ? $conversation->agent->name : 'Unassigned') }}
        </h2>

        @if (auth()->user()->isAgent() && !$conversation->agent_id)
            <form action="{{ route('support.assign', $conversation) }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-success">Assign to Me</button>
            </form>
        @endif

        <div class="chat-box">
            @foreach ($conversation->messages as $message)
                <div class="message {{ $message->user_id === auth()->id() ? 'mine' : '' }}">
                    <span class="sender">{{ $message->user->name }}</span>
                    <span class="time">{{ $message->created_at->diffForHumans() }}</span>
                    <p>{{ $message->content }}</p>
                </div>
            @endforeach
        </div>

        <form action="{{ route('support.store', $conversation) }}" method="POST" class="mt-3">
            @csrf
            <div class="input-group">
                <textarea class="form-control" name="content" rows="2" placeholder="Type your message..." required></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
            @error('content')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </form>
    </div>

    <script>
        const chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>

</x-app-layout>
