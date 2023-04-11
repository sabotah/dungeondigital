<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Creature extends Model
{
	protected $fillable = ['name','size','type','subtype','alignment','armor_class','hit_points','hit_dice','speed','strength','dexterity','constitution','intelligence','wisdom','charisma','dexterity_save','constitution_save','intelligence_save','wisdom_save','charisma_save','perception','stealth','damage_vulnerabilities','damage_resistances','damage_immunities','condition_immunities','senses','languages','challenge_rating'];
    
    public function actions(): BelongsToMany
    {
    	return $this->belongsToMany(Action::class);
    }

    public function abilities(): BelongsToMany
    {
    	return $this->belongsToMany(Ability::class);
    }

    public function rooms(): BelongsToMany
    {
    	return $this->belongsToMany(Room::class);
    }


    public function campaigncreatures(): HasMany
    {
        return $this->hasMany(CampaignCreature::class);
    }
}
