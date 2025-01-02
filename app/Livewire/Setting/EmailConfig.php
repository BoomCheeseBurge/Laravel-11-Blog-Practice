<?php

namespace App\Livewire\Setting;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmailConfig extends Component
{
    use LivewireAlert;
    
    public User $user;

    #[Validate]
    public string $newMail = '';

    protected function rules() 
    {
        return [
            'newMail' => ['required', 'email:dns', Rule::unique('users')->ignore($this->user->id)],
        ];
    }

    public function saveEmail(Request $request)
    {
        $this->validate();

        $this->user->email = $this->newMail;

        $this->user->save();
        
        $this->reset('newMail');

        $this->alert('success', 'Email successfully updated.', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
 
        return;
    }

    public function render()
    {
        return view('livewire.setting.email-config');
    }
}
