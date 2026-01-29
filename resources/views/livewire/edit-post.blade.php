
<form wire:submit.prevent="save">
      <p><small><strong><a href="/post/{{$post->id}}">
        &laquo/ back to post permalink</a></strong></small>
      </p>
        <div class="form-group">
          <label for="post-title" class="text-muted mb-1">
            <small>Title</small>
          </label>
          <input wire:model="title"
            id="post-title"
            class="form-control form-control-lg form-control-title" 
            type="text" placeholder="" autocomplete="off" />
          @error('title')
            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="post-body" class="text-muted mb-1">
            <small>Body Content</small>
          </label>
          <div wire:ignore>
          <input id="body" type="hidden" name="body" 
            wire:model.defer="body">
          <trix-editor input="body"></trix-editor>
          </div>

          @error('body')
          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
          @enderror 
        </div>       
        
        <button class="btn btn-primary">Save Changes</button>
      </form>

@push('scripts')
<script>
  console.log("script");
  document.addEventListener("livewire:navigated", ()=> loadTrix());
  document.addEventListener("DOMContentLoaded", ()=> loadTrix());
  function loadTrix(){
    let trix = document.querySelector("trix-editor");
    let body = @js($body);
    if (trix.editor && body){
      console.log("trix and body");
      trix.editor.loadHTML(body);
    }
  }
  document.addEventListener("trix-change", function(event){
    @this.set('body', event.target.value);
  });
  document.addEventListener("trix-attachment-add", function(event){
    if(event.attachment.file){
      uploadTrixImage(event.attachment);
    }
  });
  function uploadTrixImage(attachment){
    let formData = new FormData();
    formData.append('image', attachment.file);

    fetch("/trix-image-upload",{
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
      },
      body:formData
    })    

    .then(response=>response.json())
    .then(data=>{
      attachment.setAttributes({
        url: data.url,
        href: data.full
      });
    });
  }
</script>
@endpush
