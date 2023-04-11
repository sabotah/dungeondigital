<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomEntity extends Model
{

    // protected $fillable = [
    //     'room_id','entity_id'
    // ];
    protected $touches = ['room'];
   
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }    
    
	// setup the start and end based on the parent entity dimensions and the starting cells (named offset)
    public function getEndRow() {
    	$endrow = $this->offset_row + $this->entity->height;
    	return $endrow;	
    }

    public function getEndCol() {
    	$endcol = $this->offset_col + $this->entity->width;
    	return $endcol;	
    }
}
