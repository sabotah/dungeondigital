<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ability extends Model
{
	protected $fillable = ['name','desc','attack_bonus','damage_dice','damage_bonus'];
    
    public function creatures(): HasMany
    {
        return $this->hasMany(Creature::class);
    }
}
