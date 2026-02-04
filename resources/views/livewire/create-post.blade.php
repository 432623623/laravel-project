 <form wire:submit.prevent="create">
        <div class="form-group">
          <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
          <input 
            wire:model.defer="title" 
            class="form-control form-control-lg form-control-title" 
            type="text" 
            autocomplete="off" />
          @error('title')
          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
          @enderror
        </div>

        <div class="form-group" wire:ignore>
          <label for="post-body" class="text-muted mb-1">
            <small>Body Content</small>
          </label>
          <input id="body" type="hidden" name="body">
          <trix-editor input="body"></trix-editor>
          @error('body')
          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
          @enderror 
        </div>
        <button class="btn btn-primary"> 
          Save New Post
        </button>
        </div>
      </form>
@push('scripts')
<script>
  document.addEventListener("trix-toolbar-init", function(event){
    const toolbar = event.target;
    const linkInput = toolbar.querySelector("input[name='href']");
    if(linkInput){
      linkInput.setAttribute("placeholder", "Use full URL (e.g. https://example.com)");
    }
  });
  document.addEventListener("trix-change", function(event){
    let el = event.target.closest('[wire\\:id]')
    if(!el) return

    let component = Livewire.find(el.getAttribute('wire:id'))
    if(!component) return

    component.set('body', event.target.innerHTML)
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
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      body: formData
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