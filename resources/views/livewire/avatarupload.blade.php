<form wire:submit.prevent="save" >
            <div class="mb-3">
                <input 
                wire:loading.attr="disabled" 
                wire:target="avatar" 
                wire:model="avatar" 
                accept="image/*"
                type="file" 
                name="avatar">
                @error('avatar')
                <p class="alert small alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>
            <button wire:loading.attr="disabled" wire:target="avatar" class="btn btn-primary">Save</button>
        </form>