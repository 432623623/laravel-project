<x-layout>
<div class="container mt-4">

<h2>Manage Users</h2>
<div>Total users: {{ $users->count()}}</div>
<table class="table table-bordered mt-2" >
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Avatar</th>
            <th>Date created</th>
            <th>Email</th>
            <th>Posts</th>
            <th>Followers</th>
            <th>Following</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>
                {{ $user->id }}
                
            </td>
            <td>
            <a href="/profile/{{ $user->username }}">
                <div>{{ $user->username }}</div>
                <div class="mt-l">
                @if($user->isAdmin())
                <span class="badge badge-danger ml-1">Admin</span>
                @endif
                @if($user->isBanned())
                <span class="badge badge-secondary ml-1">Banned</span>
                @endif          
                </div>              
            </a>
            </td>
            <td>
            <a href="/profile/{{$user->username}}" 
                class="mr-2"><img title="{{$user->username}}" 
                style="width: 32px; height: 32px; border-radius: 16px" 
                src="{{$user->avatar}}" /></a>
                <form method="POST"
                    action="{{ route('admin.users.avatar.destroy',$user) }}"
                    style="display:inline"
                    onsubmit="return confirm('Delete avatar?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm m-1 btn-warning">
                        del
                    </button>
                </form>
            </td>
            <td>{{ $user->created_at }}</td>

            <td>{{ $user->email }}</td>
            <td>{{ $user->posts_count }}</td>
            <td>{{ $user->followers()->count() }}</td>
            <td>{{ $user->following()->count() }}</td>

            <td>
                @if(!$user->is_banned)
                <form method="POST"
                    action="{{ route('admin.users.ban', $user) }}"
                    style="display:inline"
                    onsubmit="return confirm('Ban user?');">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-warning">Ban</button>
                </form>
                @else
                <form method="POST"
                    action="{{route('admin.users.unban',$user)}}"
                    style="display:inline"
                    onsubmit="return confirm('Unban user?');">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-success">Unban</button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.users.destroy', $user)}}"
                    onsubmit="return confirm('Permanently delete user?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No posts found.</td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>
</x-layout>