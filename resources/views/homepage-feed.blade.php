<x-layout>
    <div class="container py-md-5 container--narrow">
      @unless($posts->isEmpty())
      <h2 class="text-center mb-4">Posts from Followed Users</h2>
        <div class="list-group">
        @foreach($posts as $post)
        <x-post :post="$post"/>
        @endforeach        
      </div>
      <div class="mt-4">
        {{$posts->links()}}
      </div>
      @else
      <div class="text-center">
        <h2>Hello <strong>{{auth()->user()->username}}</strong>, your feed is empty.</h2>
        <p class="lead text-muted">See posts from users you follow.</p>
      </div>
      @endunless
    </div>

</x-layout>