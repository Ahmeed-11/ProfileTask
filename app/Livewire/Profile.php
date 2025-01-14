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

    // Define validation rules
    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'image' => 'nullable|image'
    ];



    public function update()
    {

        // Validate the input fields
        $this->validate();

        // get last profile
        $profile = ModelProfile::latest()->first();

        // img = same image if user already has image or null
        $filename = $profile->image ?? null;


        // img = new image if user update his image
        if ($this->image) {

            // delete old image if exists
            if ($profile && $profile->image && Storage::exists('public/profile_images/' . $profile->image)) {
                Storage::delete('public/profile_images/' . $profile->image);
            }

            // Store new image
            $filename = $this->image->getClientOriginalName();
            $this->image->storeAs('public/profile_images', $filename);
        }


        // if a profile exists, update its values

        if ($profile) {
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

        // Flash success message
        session()->flash('message', 'Profile updated successfully!');
    }
    public function render()
    {
        // In our case, we do not have any users,
        // so we will only modify the last line of the DATABASE
        // because there will only be one row.

        $profile = ModelProfile::latest()->first();

        return view('livewire.profile', compact('profile'));
    }
}
