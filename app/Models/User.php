<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $touches = ["roles"];

    public function address(): HasOne {
        return $this->hasOne(Address::class)->latestOfMany();
    }

    /*
     * If a user has many addresses even if his/her relationship is one-to-one,
     * In laravel 8.4x, we can get the oldest or latest of addresses that have been added to DB
     * latestOfMany or oldestOfMany both will retrieve the latest or oldest related model based on the model's primary key,
     * which must be sortable.
     *
     * */

    public function oldestAddress(): HasOne {
        //return $this->hasOne(Address::class)->oldestOfMany(); //OR
        return $this->hasOne(Address::class)->ofMany('created_at', 'min');
    }

    public function latestAddress(): HasOne {
        //return $this->hasOne(Address::class)->ofMany("created_at", "max"); //OR
        return $this->hasOne(Address::class)->latestOfMany();
    }

    //advanced query with ofMany
    public function currentAddress(): HasOne {
        return $this->hasOne(Address::class)->ofMany([
            "created_at" => "max", //in case created_at is the same, or other column value is the same, it will rely on id
            "id" => "min"
        ], function ($query) { //this closure is optional to this relationship, means if no additional query, don't added it
            //run additional query here...
            //$query->where('name', 'Kompot');
        });
    }

    //hasOneThrough Postal Model
    public function addressPostal(): HasOneThrough {
        return $this->hasOneThrough(Postal::class, Address::class);
    }

    public function articles(): HasMany {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    //a user has many roles
    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

}
