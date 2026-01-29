<x-layout>
<div class="container mt-4">

<h2>Manage Posts</h2>
<div>Total posts: {{ $posts->count()}}</div>

<table class="table table-bordered mt-3" >
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Author</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>
                <a href="/post/{{ $post->id }}" target="_blank">
                    {{ $post->title }}
                </a>
            </td>
            <td>
                @if($post->image)
                    <a target="_blank" href="{{ asset('storage/' . $post->image) }}">
                        <img class="post-thumbnail-mini"
                            src="{{ asset('storage/' . $post->image) }}"          
                            alt="{{ $post->title }}"
                        >
                    </a>
                @else
                    <p>none</p>
                @endif
            </td>
            <td>
                <a href="/profile/{{$post->user->username}}" 
                class="mr-2">
                <img class="avatar-tiny" src="{{$post->user->avatar}}" />
                {{ $post->user->username ?? '-' }}
                @if($post->user->isAdmin())
                <span class="badge badge-danger ml-1">Admin</span>
                @endif
                @if($post->user->isBanned())
                <span class="badge badge-secondary ml-1">Banned</span>
                @endif
                </a>
            </td>
            <td>{{ $post->created_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('admin.posts.edit', $post) }}">
                    Edit
                </a>
                <form method="POST"
                    action="{{ route('admin.posts.destroy', $post) }}"
                    style="display:inline"
                    onsubmit="return confirm('Delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
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