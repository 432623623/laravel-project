<x-layout :doctitle="$post->title">   
    <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{$post->title}}</h2>
        <livewire:post-actions :post="$post" />
      </div>

      <p class="text-muted small mb-4">
        <a wire:navigate href="/profile/{{$post->user->username}}">
          <img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
        Posted by <a wire:navigate href="/profile/{{$post->user->username}}">
          {{$post->user->username}}</a> on {{$post->created_at->format('n/j/Y')}}
      </p>

      <div class="body-content">
        {!! $post->body !!}
      </div>
    </div>
</x-layout>
