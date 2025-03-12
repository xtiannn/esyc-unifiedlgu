<x-app-layout>
    <h2>Manage Bot Responses</h2>
    <a href="{{ route('bot_responses.create') }}">Add Response</a>
    <table>
        <tr>
            <th>User Message</th>
            <th>Bot Response</th>
            <th>Actions</th>
        </tr>
        @foreach ($responses as $response)
            <tr>
                <td>{{ $response->user_message }}</td>
                <td>{{ $response->bot_response }}</td>
                <td>
                    <a href="{{ route('bot_responses.edit', $response) }}">Edit</a>
                    <form action="{{ route('bot_responses.destroy', $response) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</x-app-layout>
