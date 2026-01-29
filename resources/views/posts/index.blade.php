<x-layout>
    <div class="container container--narrow">
        <h2 class="mb-4">Posts</h2>
      <div class="list-group">
        @foreach($posts as $post)
        <x-post :post="$post"/>
        @endforeach        
      </div>
        {{ $posts->links() }}
    </div>
</x-layout>