<x-layout>
    <div class="container">
        <h3>Admin Dashboard</h3>
        <p>Welcome {{ auth()->user()->username}}</p>
        <li><a href="{{ route('admin.posts.index')}}">Posts</a></li>
        <li><a href="{{ route('admin.users.index')}}">Users</a></li>
        <li><a href="{{ url('/') }}">Back to site</a></li>
    </div>
</x-layout>