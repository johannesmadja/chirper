<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chirp extends Model
{
    use HasFactory;

    /**
     * Champs qu'on peut soumettre
     * @var mixed
     */
    private $fillable = [
        'message'
    ];

    /**
     * Champs qu'on ne peut pas soumettre
     * @var mixed
     */
    protected $guard = [];
}
