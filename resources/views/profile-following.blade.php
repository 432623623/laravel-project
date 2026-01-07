<x-profile :sharedData="$sharedData" doctitle="Who {{$sharedData['username']}} Follows">  
      <div class="list-group">
        @forelse($followings as $follow)
        <a wire:navigate href="/profile/{{$follow->userBeingFollowed->username}}" 
          class="list-group-item list-group-item-action">
          <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}" />
          {{$follow->userBeingFollowed->username}}
        </a>
        @empty
        <div class="list-group-item text-muted">
          Not following anyone
        </div>
        @endforelse      
      </div>
</x-profile>