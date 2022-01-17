<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Postal extends Model {

    use HasFactory;

    public function address(): BelongsTo {
        return $this->belongsTo(Address::class);
    }
}
