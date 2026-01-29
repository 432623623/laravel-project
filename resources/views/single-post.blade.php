<x-layout :doctitle="$post->title">   
    <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{$post->title}}</h2>
        <livewire:post-actions :post="$post" />
      </div>

      <p class="text-muted small mb-4">
        <a wire:navigate href="/profile/{{$post->user->username}}">
          <img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
        Posted by 
        <a wire:navigate href="/profile/{{$post->user->username}}">
          {{$post->user->username}}
          @if($post->user->isAdmin())
          <span class="badge badge-danger ml-1">Admin</span>
          @endif
          @if($post->user->isBanned())
          <span class="badge badge-secondary ml-1">Banned</span>
          @endif
        </a> 
        on {{$post->created_at->format('n/j/Y')}}
      </p>
      {{-- 
      
      --}}
      @if($post->image)
      <div class="mb-4 text-center">
        <a target="_blank" href="{{ asset('storage/' . $post->image) }}">
        <img class="post-thumbnail"
          src="{{ asset('storage/' . $post->image) }}"          
          alt="{{ $post->title }}"
          >
        </a>
      </div>
      @endif
      <div class="body-content">
        {!! $post->body !!}
      </div>

      <hr>
      <h4>Comments</h4>
      @auth
          <form method="POST" action="{{ route('comments.store',$post)}}" class="mb-4">
            @csrf
            <textarea name="body" class="form-control mb-2" rows="3" 
              placeholder="Write a comment"></textarea>
              <button class="btn btn-sm btn-primary">Post Comment</button>
          </form>
      @endauth
      @foreach ($post->comments()->oldest()->get() as $comment)
          <div class="mb-3 p-2 border rounded">
          <a wire:navigate href="/profile/{{$comment->user->username}}" 
            class="d-block text-decoration-none text-dark">
            <img class="avatar-tiny" src="{{$comment->user->avatar}}" />
            <strong>{{ $comment->user->username }}</strong></a>
            <span class="text-muted small">· {{ $comment->created_at->diffForHumans() }}</span>
            <p class="mb-0 mt-1">{{ $comment->body }}</p>
            @can('delete',$comment)
              <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                class="d-block mt-2" onsubmit="return confirm('Delete comment?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            @endcan
          </div>      
      @endforeach
    </div>
</x-layout>
