<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{

    protected $fillable = ['name'];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function doors(): HasMany
    {
        return $this->hasMany(Door::class);
    }    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(CampaignArea::class);
    }

    public function campaigncreatures(): HasMany
    {
        return $this->hasMany(CampaignCreature::class);
    }

    public function environments(): HasMany
    {
        return $this->hasMany(Environment::class);
    }
}
