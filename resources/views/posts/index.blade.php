<x-layout>
    <div class="container container--narrow">
        <h2 class="mb-4">Posts</h2>
      <div class="list-group">
        @forelse($posts as $post)
        <x-post :post="$post"/>
        @empty
        <div class="text-muted mb-4">No posts</div>
        @endforelse        
      </div>
        {{ $posts->links() }}
    </div>
</x-layout>