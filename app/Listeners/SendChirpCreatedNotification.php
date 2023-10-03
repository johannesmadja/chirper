<?php

namespace App\Listeners;

use App\Events\ChirpCreatedEvent;
use App\Models\User;
use App\Notifications\NewChirp;
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
            # Envoi de mail aux utilisateur sauf à l'auteur du commentaire 
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
