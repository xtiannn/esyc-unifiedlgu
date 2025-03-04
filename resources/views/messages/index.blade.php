<x-app-layout>
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .messages {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
        }

        .message .user {
            font-weight: bold;
            color: #007bff;
        }

        .message .time {
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>

    <div class="chat-container">
        <h2 class="mb-4">Chat Room</h2>

        <!-- Messages Display -->
        <div class="messages">
            @forelse ($messages as $message)
                <div class="message">
                    <span class="user">{{ $message->user->name }}</span>
                    <span class="time">{{ $message->created_at->diffForHumans() }}</span>
                    <p>{{ $message->content }}</p>
                </div>
            @empty
                <div class="message">
                    <p>No messages yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Message Input Form -->
        <form action="{{ route('messages.store') }}" method="POST">
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
</x-app-layout>
