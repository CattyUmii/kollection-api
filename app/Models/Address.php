<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    public function user(): BelongsTo {
        //sometimes may be passed as an array or closure to withDefault()
        return $this->belongsTo(User::class)->withDefault();
    }

    public function postal(): HasOne {
        return $this->hasOne(Postal::class)->latestOfMany();
    }

}
