<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Door extends Model
{
	protected $touches = ['area'];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
