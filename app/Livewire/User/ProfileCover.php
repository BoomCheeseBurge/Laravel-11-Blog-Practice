<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfileCover extends Component
{
    use WithFileUploads, LivewireAlert;

    #[Validate('nullable|image|mimes:png,jpeg,jpg|max:2048')]
    public $profileCover;

    public function updatedProfileCover() // Update the profile cover when there is a change in the input file
    {
        $this->validate(); // Validate the uploaded file

        // Check if the current post has an existing featured image
        if(!empty(auth()->user()->profile_cover) && Storage::disk('cover')->exists(auth()->user()->profile_cover))
        {
            // Delete the old featured image file
            Storage::disk('cover')->delete(auth()->user()->profile_cover);
        }

        $profile_cover = $this->profileCover; // Get the uploaded file

        auth()->user()->update(([
            'profile_cover' => Storage::disk('cover')->putFileAs('/', $profile_cover, str()->uuid() . '.' . $profile_cover->extension() ),
        ]));

        $this->alert('success', 'Profile cover successfully updated!', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.user.profile-cover');
    }
}
