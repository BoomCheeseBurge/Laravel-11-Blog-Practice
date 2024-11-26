<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use App\Rules\Fullname;
use App\Rules\MaxCharacter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class ProfileForm extends Form
{
    public ?User $user;

    #[Validate]
    public $about;

    #[Validate]
    public $fullname;

    #[Validate]
    public $username;

    #[Validate]
    public $email;

    #[Validate]
    public $phone_country;

    #[Validate]
    public $phone;

    #[Validate]
    public $website;

    #[Validate]
    public $sex;

    #[Validate]
    public $date_of_birth;

    #[Validate]
    public $location;

    // ----------------------------------------------------------------

    /**
     * Initialize the form's properties
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        
        $this->about = $user->about;

        $this->fullname = $user->fullname;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->sex = $user->sex ?? 0;
        $this->location = $user->location;

        $this->date_of_birth = $user->date_of_birth;
        $this->phone = $user->phone;
        $this->phone_country = $user->phone_country;
        $this->website = (empty($user->website)) ? '' : $user->website;
    }

    /**
     * Set the validation rules
     */
    public function rules(): array
    {
        return [
            'about' => ['nullable', 'ascii', new MaxCharacter(200)],
            'fullname' => ['nullable', 'max:255', new Fullname],
            'username' => ['nullable', 'min:3', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'email' => ['nullable', 'email:dns', Rule::unique('users')->ignore($this->user->id)],
            'phone_country' => 'required_with:phone | nullable',
            'phone' => 'phone | nullable',
            'website' => 'nullable | url',
            'sex' => 'nullable | integer | numeric | digits:1 | between:0,2',
            'date_of_birth' => 'date | before:today | nullable',
            'location' => 'nullable',
        ];
    }

    /**
     * Update the user model with the validated data
     */
    public function update(): array
    {
        $this->user->update($this->all()); // Update the user data

        $this->resetValidation(); //  Reset all errors if no key is supplied

        // Return if the user has been modified, user's phone number, and user's phone country
        return [$this->user->wasChanged(), $this->user->phone, $this->user->phone_country];
    }

    /**
     * Set the phone country code
     */
    public function setCode(string $phone_country): void
    {
        $this->phone_country = $phone_country;
    }

    /**
     * Reset the edit form
     */
    public function resetForm(): void
    {
        $this->about = $this->user->about;

        $this->fullname = $this->user->fullname;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->sex = $this->user->sex ?? 0;
        $this->location = $this->user->location;

        $this->date_of_birth = $this->user->date_of_birth;
        $this->phone = $this->user->phone;
        $this->phone_country = $this->user->phone_country;
        $this->website = (empty($this->user->website)) ? '' : $this->user->website;
    }
}
