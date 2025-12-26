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

        <div class="form-group">
          <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
          <textarea 
            wire:model.defer="body" 
            class="body-content tall-textarea form-control" >
            </textarea>
          
          @error('body')
          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
          @enderror 
        </div>

        <button class="btn btn-primary">Save New Post</button>
      </form>