<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\On;
use App\Livewire\Forms\ProfileForm;
use Propaganistas\LaravelPhone\PhoneNumber;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;

    public ProfileForm $form; // Declare the form object

    public $number; // Store the phone number to be displayed
    public $code; // Store the country code to be displayed

    public bool $showEdit = false; // Show/hide the edit form

    // ----------------------------------------------------------------

    /**
     * Mount the user data
     */
    public function mount(User $user): void
    {
        $this->form->setUser($user);

        // Set the phone number to be displayed
        if(!empty($user->phone_country))
        {
            $this->number = new PhoneNumber($user->phone, $user->phone_country);
            $this->number = $this->number->formatInternational();    
        } else {
            $this->number = '(+1) 123-456-7890';
        }

        // Set the phone country code for edit form
        $this->code = [
                        'AU' => '🇦🇺  (+49)',
                        'FR' => '🇫🇷  (+33)',
                        'DE' => '🇩🇪  (+61)',
                        'ID' => '🇮🇩  (+62)',
                        'GB' => '🇬🇧  (+44)',
                        'US' => '🇺🇸  (+1)',
                    
                    ][$user->phone_country] ?? 'Country (Code)';
    }

    /**
     * Update the user data
     */
    public function update(): void
    {
        $this->validate(); // Validate the necessary input fields

        [$wasChanged, $phone, $phone_country] = $this->form->update(); // Update the user profile through the form object

        $this->dispatch('reset-edit'); // Reset the edit form

        $this->showEdit = false; // Close the edit form

        if($wasChanged) // Check if any of the user data has been changed
        {
            $this->alert('success', 'User Profile successfully updated!', [
                'position' => 'center',
                'timer' => null,
                'showCloseButton' => true,
            ]);
        }

        // Reset the phone number to be displayed
        if(!empty($phone_country))
        {
            $this->number = new PhoneNumber($phone, $phone_country);
            $this->number = $this->number->formatInternational();    
        } else {
            $this->number = '(+1) 123-456-7890';
        }

        // Set the phone country code for the edit form
        $this->code = [
                        'AU' => '🇦🇺  (+49)',
                        'FR' => '🇫🇷  (+33)',
                        'DE' => '🇩🇪  (+61)',
                        'ID' => '🇮🇩  (+62)',
                        'GB' => '🇬🇧  (+44)',
                        'US' => '🇺🇸  (+1)',
                    
                    ][$phone_country] ?? 'Country (Code)';

        $this->dispatch('reset-form'); // Re-render the form
    }

    /**
     * Set the phone country code
     */
    public function setCode(string $phone_country): void
    {
        $this->form->setCode($phone_country); // Pass in the phone country to the form object
    }

    /**
     * Reset the edit form
     */
    public function resetForm(): void
    {
        $this->form->resetForm(); // Pass in the phone country to the form object
        
        $this->showEdit = false; // Close the edit form
    }
    
    #[On('reset-form')]
    public function render(): View
    {
        return view('livewire.user.profile');
    }
}
