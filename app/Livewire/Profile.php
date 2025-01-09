<?php

namespace App\Livewire;

use App\Models\Profile as ModelProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;



class Profile extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $image;



    public function update()
    {
        // get last profile
        $profile = ModelProfile::latest()->first();

        // img  = same image if user already has image or null
        $filename = $profile->image ?? null;


        // img = new image if user update his image
        if ($this->image) {

            // delete old image if exists
            if ($profile && $profile->image && Storage::exists('public/profile_images/' . $profile->image)) {
                Storage::delete('public/profile_images/' . $profile->image);
            }

            // upload new image
            $filename = $this->image->getClientOriginalName();
            $this->image->storeAs('public/profile_images', $filename);
        }


        if ($profile) {
            // if a profile exists, update its values
            $profile->update([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $filename,
            ]);
        } else {
            // if no profile exists, create new one
            ModelProfile::create([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $filename,
            ]);
        }
    }
    public function render()
    {
        $profile = ModelProfile::latest()->first();

        return view('livewire.profile', compact('profile'));
    }
}
