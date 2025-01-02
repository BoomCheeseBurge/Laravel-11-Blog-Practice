<?php

namespace App\Livewire\Setting;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PasswordChange extends Component
{
    use LivewireAlert;

    public User $user;

    #[Validate]
    public string $password;
    #[Validate]
    public string $confirmPassword;

    protected function rules() 
    {
        return [
            'password' => ['required', 'max:255', Password::defaults()],
            'confirmPassword' => ['confirmed:password'],
        ];
    }

    public function savePassword()
    {
        $this->validate();

        $this->user->password = Hash::make($this->password);

        $this->user->save();

        $this->reset(['password', 'confirmPassword']);

        $this->alert('success', 'Password successfully updated.', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
 
        return;
    }
    
    public function render()
    {
        return view('livewire.setting.password-change');
    }
}
