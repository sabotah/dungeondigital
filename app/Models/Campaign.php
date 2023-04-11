<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
	protected $fillable = ['name','game','rulesversion','user_id','publiclisted','discordchannelid'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class,'campaign_areas','campaign_id','area_id');
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function campaigncreatures(): HasMany
    {
        return $this->hasMany(CampaignCreature::class);
    }
}
