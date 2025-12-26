<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class Avatarupload extends Component
{
    use WithFileUploads;
    public $successMessage = null;
    public $avatar;

    public function save(){
        ini_set('memory_limit', '256M');
        if(!auth()->check()){
            abort(403, "Unauthorized");
        }
        $this->validate([
            'avatar' => 'required|image|max:5120', // 5MB
        ]);
        $user = auth()->user();
        $filename = $user->id . "-" . uniqid() . ".jpg";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar);
        $imgData = $image->cover(120,120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $filename, $imgData);
        $oldAvatar = $user->avatar;
        $user->avatar = $filename;
        $user->save();
        if($oldAvatar != "/fallback-avatar.jpg"){
            Storage::disk('public')->delete(str_replace("/storage/","",$oldAvatar));
        }
        session()->flash('success','Avatar uploaded');
        return $this->redirect('/manage-avatar'); // no navigate parameter    
    }
    public function updatedAvatar(){
        session()->forget('success');
        $this->resetValidation('avatar');
    }
    public function render()
    {
        return view('livewire.avatarupload');
    }
}
