<x-layout>
    <div class="container mt-4">
        <h2>Search Results for "{{ $q }}"</h2>

        @if($users->count() > 0 )
            <h4 class="mt-4">Users</h4>
            <div class="list-group mb-4">
                @foreach($users as $user)
                    <a href="/profile/{{ $user->username }}" 
                        class="list-group-item list-group-item-action align-items-baseline d-flex">
                        <img src="{{ $user->avatar}}" 
                            class="avatar-tiny mr-1" alt="{{ $user->username }}">
                            <strong>{{ $user->username }}</strong>
                            @if($user->isAdmin())
                                <span class="badge badge-danger ml-2">Admin</span>
                            @endif
                            @if($user->isBanned())
                                <span class="badge badge-secondary m1-2">Banned</span>
                            @endif
                    </a>
                @endforeach
            </div>
        @endif

        @if($posts->count() > 0 )
            <h4 class="mt-4">Posts</h4>
            <div class="list-group mb-4">
                @foreach($posts as $post)
                        <a href="/post/{{ $post->id }}"
                            class="list-group-item list-group-item-action align-items-baseline d-flex align-items-left gap-2">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image )}}" 
                                class="post-thumbnail-mini mr-2" alt="{{ $post->title}}">
                        @else
                            <img src="{{ $post->user->avatar }}" 
                                class="avatar-tiny mr-1" alt="{{ $post->user->username }}"></img>
                        @endif
                            <strong class="me-3">{{ $post->title }}</strong>
                            <span class="text-muted small ml-2">
                                by <span>{{ $post->user->username }}</span>
                                on {{ $post->created_at->format('n/j/Y') }}
                            </span>                       
                        </a>
                @endforeach
            </div>
        @endif    
        
        @if($posts->count() === 0 && $users->count() === 0)
            <p>
                No results
            </p>
        @endif
    </div>
</x-layout>