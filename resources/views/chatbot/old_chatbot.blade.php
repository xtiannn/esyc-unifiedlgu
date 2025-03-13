{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .chat-container {
            width: 400px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .chat-box {
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }

        .user,
        .bot {
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
        }

        .user {
            background: #007bff;
            color: white;
            text-align: right;
        }

        .bot {
            background: #f1f1f1;
            color: black;
            text-align: left;
        }

        .input-container {
            display: flex;
            margin-top: 10px;
        }

        input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 8px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="chat-box" id="chat-box"></div>
        <div class="input-container">
            <input type="text" id="message" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            let message = $('#message').val();
            if (!message.trim()) return;

            $('#chat-box').append('<div class="user">' + message + '</div>');
            $('#message').val('');

            $.ajax({
                url: '/chatbot',
                method: 'POST',
                data: {
                    message: message,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let botReply = response.choices[0].message.content;
                    $('#chat-box').append('<div class="bot">' + botReply + '</div>');
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                },
                error: function() {
                    $('#chat-box').append('<div class="bot">Error processing request.</div>');
                }
            });
        }
    </script>
</body>

</html> --}}
