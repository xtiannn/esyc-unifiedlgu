<x-app-layout>
    <style>
        /* Chat container takes full width of parent */
        .chat-container {
            width: 100%;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow: hidden;
            margin: 0 auto;
        }

        .chat-title {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chat-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            scrollbar-width: thin;
            scrollbar-color: #b0b0b0 #f9fafb;
        }

        .chat-box::-webkit-scrollbar {
            width: 8px;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background: #b0b0b0;
            border-radius: 4px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        .message {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .message.user {
            background: #007bff;
            color: #fff;
            align-self: flex-end;
            text-align: right;
        }

        .message.bot {
            background: #28a745;
            color: #fff;
            align-self: flex-start;
        }

        .message.error {
            background: #dc3545;
            color: #fff;
            align-self: flex-start;
        }

        .message a {
            color: #fff;
            text-decoration: underline;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .message a:hover {
            color: #e0e0e0;
        }

        .typing-indicator {
            display: none;
            align-self: flex-start;
            padding: 12px;
        }

        .typing-indicator span {
            display: inline-block;
            width: 10px;
            height: 10px;
            background: #28a745;
            border-radius: 50%;
            margin-right: 6px;
            animation: bounce 0.6s infinite alternate;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-12px);
            }
        }

        .input-area {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .input-area input {
            flex: 1;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-area input:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
        }

        .input-area button {
            padding: 12px 24px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .input-area button:hover {
            background: #0056b3;
        }

        .admin-btn {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s ease;
            display: none;
        }

        .admin-btn:hover {
            background: #b02a37;
        }
    </style>

    <div class="container-fluid">
        <div class="chat-container">
            <h4 class="chat-title">LGU Chatbot</h4>

            <!-- Chat Box -->
            <div id="chat-box" class="chat-box">
                <!-- Messages will be appended here -->
            </div>

            <!-- Input Area -->
            <div class="input-area">
                <input type="text" id="user-message" placeholder="Type a message...">
                <button onclick="sendMessage()">Send</button>
            </div>

            <!-- Chat with Admin Button (hidden by default) -->
            <button id="chat-admin-btn" class="admin-btn" onclick="chatWithAdmin()">Chat with Admin</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('user-message');
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.which === 13) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        });

        function parseLinks(text) {
            // Convert [Text](URL) to <a href="URL">Text</a>
            return text.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank">$1</a>');
        }

        function sendMessage() {
            let userMessage = document.getElementById('user-message').value.trim();
            if (!userMessage) return;

            let chatBox = document.getElementById('chat-box');
            let userDiv = document.createElement('div');
            userDiv.className = 'message user';
            userDiv.textContent = userMessage;
            chatBox.appendChild(userDiv);

            let typingDiv = document.createElement('div');
            typingDiv.className = 'typing-indicator';
            typingDiv.id = 'typing';
            typingDiv.innerHTML = '<span></span><span></span><span></span>';
            chatBox.appendChild(typingDiv);
            typingDiv.style.display = 'flex';
            chatBox.scrollTop = chatBox.scrollHeight;

            $.ajax({
                url: '{{ route('chat.send') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    message: userMessage
                },
                success: function(response) {
                    document.getElementById('typing').remove();

                    let botResponse = response.bot_response;
                    let botDiv = document.createElement('div');
                    botDiv.className = 'message bot';
                    botDiv.innerHTML = parseLinks(botResponse); // Parse links
                    chatBox.appendChild(botDiv);

                    if (botResponse.includes("I’m not quite sure I understand") ||
                        botResponse.includes("Would you like to chat with an admin")) {
                        document.getElementById('chat-admin-btn').style.display = 'block';
                    } else {
                        document.getElementById('chat-admin-btn').style.display = 'none';
                    }

                    chatBox.scrollTop = chatBox.scrollHeight;
                },
                error: function(xhr) {
                    document.getElementById('typing').remove();

                    console.error('Error:', xhr);
                    let errorDiv = document.createElement('div');
                    errorDiv.className = 'message error';
                    errorDiv.textContent = 'Oops! Something went wrong. Please try again.';
                    chatBox.appendChild(errorDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });

            document.getElementById('user-message').value = '';
        }

        function chatWithAdmin() {
            $.ajax({
                url: '{{ route('chat.connect-admin') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        window.location.href = '/admin/chat/' + response.admin_id;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    alert('Failed to connect to admin. Please try again.');
                }
            });
        }
    </script>
</x-app-layout>
