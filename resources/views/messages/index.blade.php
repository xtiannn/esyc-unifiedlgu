<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap-grid.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap-buttons.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: -50px;
            font-family: Arial, sans-serif !important;
            background-color: #f8f9fa !important;
        }

        .chat-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        #chat-box {
            border: 1px solid #ccc !important;
            border-radius: 10px !important;
            padding: 10px !important;
            height: 400px !important;
            overflow-y: auto !important;
            background: #fff !important;
            display: flex;
            flex-direction: column;
        }

        .message {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
            max-width: 75%;
        }

        .user-message {
            background: #007bff !important;
            color: white !important;
            padding: 10px 15px !important;
            border-radius: 15px !important;
            max-width: 70% !important;
            align-self: flex-end !important;
            text-align: right !important;
            margin-left: auto !important;
        }

        .bot-message {
            background: #28a745 !important;
            color: white !important;
            padding: 10px 15px !important;
            border-radius: 15px !important;
            max-width: 70% !important;
            align-self: flex-start !important;
            margin-right: auto !important;
        }

        .input-group {
            margin-top: 15px;
        }

        #chat-admin-btn {
            display: none;
            margin-top: 10px;
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        #chat-admin-btn:hover {
            background-color: #c82333;
        }
    </style>

    <div class="container">
        <div class="chat-container mt-4">
            <h4 class="text-center mb-3">LGU Chatbot</h4>
            <div id="chat-box" class="p-3"></div>

            <div class="input-group">
                <input type="text" id="user-message" class="form-control" placeholder="Type a message...">
                <button class="btn btn-primary" onclick="sendMessage()">Send</button>
            </div>

            <button id="chat-admin-btn" class="btn btn-danger mt-2" onclick="chatWithAdmin()">Chat with Admin</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Listen for "Enter" key press in input field
            $("#user-message").keypress(function(e) {
                if (e.which === 13) { // 13 is the keycode for Enter
                    sendMessage();
                    return false; // Prevents the default form submission
                }
            });
        });

        function sendMessage() {
            let userMessage = $('#user-message').val().trim();
            if (!userMessage) return;

            $('#chat-box').append('<div class="message user-message">' + userMessage + '</div>');

            $.ajax({
                url: '/chat/send',
                type: 'POST',
                data: {
                    message: userMessage,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let botResponse = response.bot_response;
                    $('#chat-box').append('<div class="message bot-message">' + botResponse + '</div>');

                    // Show "Chat with Admin" button if bot doesn't understand
                    if (botResponse ===
                        "I'm not quite sure I understand. Would you like to chat with an admin for further assistance, or can you try rephrasing your question?"
                    ) {
                        $('#chat-admin-btn').show();
                    } else {
                        $('#chat-admin-btn').hide();
                    }

                    // Auto-scroll to bottom
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                }
            });

            $('#user-message').val('');
        }

        function chatWithAdmin() {
            $.ajax({
                url: '/chat/connect-admin',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        window.location.href = '/admin/chat/' + response.admin_id; // Redirect to chat page
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    </script>
</x-app-layout>
