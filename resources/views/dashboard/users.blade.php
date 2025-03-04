<x-app-layout>
    <div class="row">
        <div class="col-md-10">
            <h1>User Dashboard</h1>
        </div>
    </div>
    <p>Welcome, {{ Auth::user()->name }}</p>
</x-app-layout>
