<x-layout>
    <div class="container container--narrow">
        <h2 class="mb-4">Users</h2>
      <div class="list-group">
        @foreach($users as $user)
        <x-user :user="$user"/>
        @endforeach        
      </div>
        {{ $users->links() }}
    </div>
</x-layout>