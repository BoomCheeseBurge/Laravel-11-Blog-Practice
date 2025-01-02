<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->user instanceof MustVerifyEmail && !$this->user->hasVerifiedEmail()) {
            $this->user->sendEmailVerificationNotification();
        }
    }
}
