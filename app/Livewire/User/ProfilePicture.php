<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfilePicture extends Component
{
    use WithFileUploads, LivewireAlert;

    #[Validate('nullable|image|mimes:png,jpeg,jpg|max:1024')]
    public $profilePic;

    public function updatedProfilePic() // Update the profile cover when there is a change in the input file
    {
        $this->validate(); // Validate the uploaded file

        // Check if the current post has an existing featured image
        if(!empty(auth()->user()->profile_pic) && Storage::disk('profile')->exists(auth()->user()->profile_pic))
        {
            // Delete the old featured image file
            Storage::disk('profile')->delete(auth()->user()->profile_pic);
        }

        $profile_pic = $this->profilePic; // Get the uploaded file

        auth()->user()->update(([
            'profile_pic' => Storage::disk('profile')->putFileAs('/', $profile_pic, str()->uuid() . '.' . $profile_pic->extension() ),
        ]));

        $this->alert('success', 'Profile picture successfully updated!', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.user.profile-picture');
    }
}
