<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    protected $fillable = ['name','class','race', 'charsheet','charsheetfile'];

    protected $touches = ['room'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }

    public function environments(): BelongsToMany
    {
        return $this->belongsToMany(Environment::class);
    }

    public function rooms(): BelongsToMany
    {
    	return $this->belongsToMany(Room::class);
    }

}
