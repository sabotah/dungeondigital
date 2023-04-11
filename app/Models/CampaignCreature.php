<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignCreature extends Model
{
	protected $fillable = ['name','size','type','subtype','alignment','armor_class','hit_points','hit_dice','speed','strength','dexterity','constitution','intelligence','wisdom','charisma','dexterity_save','constitution_save','intelligence_save','wisdom_save','charisma_save','perception','stealth','damage_vulnerabilities','damage_resistances','damage_immunities','condition_immunities','senses','languages','challenge_rating'];

	public function creature(): BelongsTo
	{
		return $this->belongsTo(Creature::class);
	}

	public function campaign(): BelongsTo
	{
		return $this->belongsTo(Campaign::class);
	}

	public function area(): BelongsTo
	{
		return $this->belongsTo(Area::class);
	}

	public function room(): BelongsTo
	{
		return $this->belongsTo(Room::class);
	}
}