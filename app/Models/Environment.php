<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Environment extends Model
{

    protected $touches = ['area'];

    public function rows(): HasMany
    {
        return $this->hasMany(EnvironmentRow::class);
    }    

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

	public function characters(): HasMany
	{
		return $this->hasMany(Character::class);
	}

	public function campaigncreatures(): HasMany
    {
        return $this->hasMany(CampaignCreature::class);
    }

    public function extensions(): HasMany
    {
        return $this->hasMany(Extension::class);
    }
}
