<!-- Blade Template (resources/views/messages/index.blade.php) -->
<x-app-layout>
    <div class="container py-4">
        <h3 class="mb-4">Real-time Messenger</h3>

        <!-- Messages Container -->
        <div class="card shadow-sm">
            <div class="card-body" style="max-height: 500px; overflow-y: auto;" id="messages-container">
                <div id="messages">
                    @foreach ($messages as $msg)
                        <div class="message mb-3 {{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
                            <div class="message-content p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>{{ $msg->sender->name }}</strong>
                                    <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                </div>
                                <span>{{ $msg->message }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Message Form -->
        <form id="messageForm" class="mt-4">
            @csrf
            <div class="input-group">
                <select id="receiver_id" class="form-select" required>
                    <option value="">Select Recipient</option>
                    @foreach (App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="text"
                       id="message"
                       class="form-control"
                       placeholder="Type your message..."
                       required
                       maxlength="500">
                <button type="submit" class="btn btn-primary" id="sendBtn">Send</button>
            </div>
            <div id="error-message" class="text-danger mt-2" style="display: none;"></div>
        </form>
    </div>

    <!-- Styles -->
    <style>
        .message.sent { margin-left: 20%; }
        .message.received { margin-right: 20%; }
        .message.sent .message-content {
            background-color: #007bff;
            color: white;
        }
        .message.received .message-content {
            background-color: #f8f9fa;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.pusher.com/8.0/pusher.min.js"></script>
    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Auto-scroll to bottom
            const messagesContainer = $('#messages-container');
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);

            // Form submission
            $('#messageForm').submit(function(e) {
                e.preventDefault();
                const sendBtn = $('#sendBtn');
                const errorMessage = $('#error-message');

                sendBtn.prop('disabled', true);
                errorMessage.hide();

                $.ajax({
                    url: '/messages',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        receiver_id: $('#receiver_id').val(),
                        message: $('#message').val()
                    },
                    success: function(response) {
                        $('#message').val('');
                        sendBtn.prop('disabled', false);
                    },
                    error: function(xhr) {
                        errorMessage.text(xhr.responseJSON?.message || 'Failed to send message');
                        errorMessage.show();
                        sendBtn.prop('disabled', false);
                    }
                });
            });

            // Real-time message listening
            Echo.private(`chat.${{{ auth()->id() }}}`)
                .listen('MessageSent', (e) => {
                    const isSent = e.message.sender_id === {{ auth()->id() }};
                    const messageHtml = `
                        <div class="message mb-3 ${isSent ? 'sent' : 'received'}">
                            <div class="message-content p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>${isSent ? 'You' : e.sender_name}</strong>
                                    <small class="text-muted">just now</small>
                                </div>
                                <span>${e.message.message}</span>
                            </div>
                        </div>
                    `;
                    $('#messages').append(messageHtml);
                    messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
                });
        });
    </script>
</x-app-layout>
