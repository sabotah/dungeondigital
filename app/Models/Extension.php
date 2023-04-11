<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Extension extends Model
{

	protected $touches = ['room'];
	
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }
}
