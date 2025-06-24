<?php

namespace App\Jobs;

use App\Notifications\OnEndNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OnEndJob implements ShouldQueue
{
    use Queueable;

   public $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $this->user->notify(new OnEndNotification());
    }
}