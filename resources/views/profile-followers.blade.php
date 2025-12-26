<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Followers">  
      <div class="list-group">
        @forelse($followers as $follow)
        <a wire:navigate href="/profile/{{$follow->userWhoFollows->username}}" class="list-group-item list-group-item-action">
          <img class="avatar-tiny" src="{{$follow->userWhoFollows->avatar}}" />
          {{$follow->userWhoFollows->username}}
        </a>
        @empty
        <div class="list-group-item text-muted">
          No followers
        </div>
        @endforelse
      </div>
</x-profile>