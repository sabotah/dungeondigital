<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Action extends Model
{
	protected $fillable = ['name','desc','attack_bonus','damage_dice','damage_bonus','legendary'];
    
    public function creatures(): HasMany
    {
        return $this->hasMany(Creature::class);
    }
}
