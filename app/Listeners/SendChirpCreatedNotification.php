<?php

namespace App\Listeners;

use App\Events\ChirpCreatedEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreatedEvent $event): void
    {
        foreach (User::whereNot('id', $event->chirp->user_id) as $user) {
            # code...
        }
    }
}
