<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        /* Chat box */
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

        /* Messages */
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

        /* Typing indicator */
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

        /* Input area */
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

        /* Admin button */
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
        $(document).ready(function() {
            $("#user-message").keypress(function(e) {
                if (e.which === 13) {
                    sendMessage();
                    return false;
                }
            });
        });

        function sendMessage() {
            let userMessage = $('#user-message').val().trim();
            if (!userMessage) return;

            $('#chat-box').append(`
                <div class="message user">${userMessage}</div>
            `);

            $('#chat-box').append(`
                <div class="typing-indicator" id="typing">
                    <span></span><span></span><span></span>
                </div>
            `);
            $('#typing').css('display', 'flex');
            $('#chat-box')[0].scrollTop = $('#chat-box')[0].scrollHeight;

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
                    $('#typing').remove();

                    let botResponse = response.bot_response;
                    $('#chat-box').append(`
                        <div class="message bot">${botResponse}</div>
                    `);

                    if (botResponse.includes("I’m not quite sure I understand") ||
                        botResponse.includes("Would you like to chat with an admin")) {
                        $('#chat-admin-btn').css('display', 'block');
                    } else {
                        $('#chat-admin-btn').css('display', 'none');
                    }

                    $('#chat-box')[0].scrollTop = $('#chat-box')[0].scrollHeight;
                },
                error: function(xhr) {
                    $('#typing').remove();

                    console.error('Error:', xhr);
                    $('#chat-box').append(`
                        <div class="message error">Oops! Something went wrong. Please try again.</div>
                    `);
                    $('#chat-box')[0].scrollTop = $('#chat-box')[0].scrollHeight;
                }
            });

            $('#user-message').val('');
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
