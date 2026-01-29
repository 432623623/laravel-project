@props(['user'])
    <li class="list-group-item">
        <a href="{{ route('profile.show', $user->username) }}">
            <img class="avatar-tiny" src="{{$user->avatar}}" />
            {{ $user->username }}
        </a>
            @if($user->isAdmin())
                <span class="badge bg-danger ms-1">Admin</span>
            @endif
            @if($user->isBanned())
                <span class="badge bg-secondary ms-1">Banned</span>
            @endif
    </li>
