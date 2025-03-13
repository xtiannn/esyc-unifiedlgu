{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .chat-wrapper {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #fafafa;
            border-bottom: 1px solid #e5e5e5;
        }

        .message {
            margin: 8px 0;
            padding: 10px;
            border-radius: 8px;
            max-width: 75%;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .user {
            background-color: #dbeafe;
            color: #1e3a8a;
            margin-left: auto;
            text-align: right;
        }

        .bot {
            background-color: #e5e7eb;
            color: #374151;
            margin-right: auto;
            text-align: left;
        }

        .suggestion {
            background-color: #3b82f6;
            color: white;
            cursor: pointer;
            display: inline-block;
            margin: 5px;
            padding: 8px 14px;
            border-radius: 20px;
            transition: background-color 0.2s ease, transform 0.1s ease;
            font-size: 0.9em;
        }

        .suggestion:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        .chat-form {
            display: flex;
            padding: 10px;
            background-color: #fff;
        }

        .chat-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 20px;
            outline: none;
            font-size: 0.95em;
            transition: border-color 0.2s ease;
        }

        .chat-input:focus {
            border-color: #3b82f6;
        }

        .chat-button {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .chat-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body>
    <div class="chat-wrapper">
        <div class="chat-header">Chatbot</div>
        <div id="chat-container" class="chat-container">
            @foreach ($messages ?? [] as $message)
                <div class="message {{ $message['sender'] === 'user' ? 'user' : 'bot' }} {{ $message['type'] === 'suggestion' ? 'suggestion' : '' }}"
                    @if ($message['type'] === 'suggestion') data-message="{{ $message['text'] }}" @endif>
                    {{ $message['text'] }}
                </div>
            @endforeach
        </div>
        <form id="chat-form" class="chat-form">
            <input type="text" name="message" id="message-input" class="chat-input" placeholder="Type a message..."
                required>
            <button type="submit" class="chat-button">Send</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');
        const chatContainer = document.getElementById('chat-container');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage(input.value);
        });

        chatContainer.addEventListener('click', function(e) {
            const suggestion = e.target.closest('.suggestion');
            if (suggestion) {
                sendMessage(suggestion.dataset.message);
            }
        });

        function sendMessage(message) {
            console.log('Sending:', message);

            // Show only the user's message immediately
            chatContainer.innerHTML = `<div class="message user">${message}</div>`;

            fetch('/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Show only the current user message and bot response
                    chatContainer.innerHTML = `<div class="message user">${message}</div>` +
                        data.messages.map(msg =>
                            `<div class="message ${msg.sender === 'user' ? 'user' : 'bot'} ${msg.type === 'suggestion' ? 'suggestion' : ''}"
                              ${msg.type === 'suggestion' ? `data-message="${msg.text}"` : ''}>
                            ${msg.text}
                        </div>`
                        ).join('');
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                    input.value = '';
                })
                .catch(error => {
                    console.error('Error:', error);
                    chatContainer.innerHTML += `<div class="message bot">Oops, something went wrong. Try again!</div>`;
                });
        }
    </script>
</body>

</html> --}}
