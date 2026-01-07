        @if($canUpdate)
        <span class="pt-2">
          <a wire:navigate href="/post/{{$post->id}}/edit" 
            class="text-primary mr-2" data-toggle="tooltip" 
            data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <livewire:deletepost :post="$post" />
        </span>
        @endif