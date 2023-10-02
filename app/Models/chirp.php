<?php

namespace App\Models;

use App\Events\ChirpCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class chirp extends Model
{
    use HasFactory;

    /**
     * Champs qu'on peut soumettre
     * @var mixed
     */
    protected $fillable = [
        'message'
    ];

    /**
     * Champs qu'on ne peut pas soumettre
     * @var mixed
     */
    protected $guard = [];

    // Un commentaire ne peut avoir qu'un auteur 
    public function user() : BelongsTo { // chirp::find(1)->user --- chirp::with('user')->get()
        return $this->belongsTo(user::class);
    }

    protected $dispatchesEvents = [
        'created' => ChirpCreatedEvent::class,
        // 'updated' => ,
        // 'deleted' => ,
    ];
}
