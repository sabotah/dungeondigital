<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnvironmentRow extends Model
{
    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }
}
