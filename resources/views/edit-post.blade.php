<x-layout doctitle="Editing: {{$post->title}}">    
    <div class="container py-md-5 container--narrow">
      <livewire:edit-post :post="$post" />
    </div>
</x-layout>
