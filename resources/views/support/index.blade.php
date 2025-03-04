<x-app-layout>

    <div class="container mt-4">
        <h2>Support Conversations</h2>
        @if (auth()->user()->isAgent())
            <h4>Open Tickets</h4>
        @else
            <a href="{{ route('support.start') }}" class="btn btn-primary mb-3">Start New Support Chat</a>
        @endif

        <ul class="list-group">
            @forelse ($conversations as $conversation)
                <li class="list-group-item">
                    <a href="{{ route('support.show', $conversation) }}">
                        Chat with
                        {{ auth()->user()->isAgent() ? $conversation->user->name : ($conversation->agent ? $conversation->agent->name : 'Unassigned') }}
                    </a>
                    <span class="badge bg-primary">{{ $conversation->messages->count() }} messages</span>
                </li>
            @empty
                <li class="list-group-item">No conversations yet.</li>
            @endforelse
        </ul>
    </div>

</x-app-layout>
