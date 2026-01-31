<x-layout>
    <div class="container container--narrow">
        <h2 class="mb-4">Users</h2>
      <div class="list-group">
        @forelse($users as $user)
        <x-user :user="$user"/>
        @empty
        <div class="text-muted">No users</div>
        @endforelse        
      </div>
        {{ $users->links() }}
    </div>
</x-layout>