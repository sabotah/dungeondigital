<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
	public function roomentities(): HasMany
	{
	    return $this->hasMany(RoomEntity::class);
	}
}
