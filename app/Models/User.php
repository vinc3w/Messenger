<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'password' => 'hashed',
    ];

    public function friendsOfMine(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'channels', 'user1_id', 'user2_id')
                    ->withPivot(Schema::getColumnListing('channels'))
                    ->as('channel');
    }
 
    public function friendsOf(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'channels', 'user2_id', 'user1_id')
                    ->withPivot(Schema::getColumnListing('channels'))
                    ->as('channel');
    }

    public function getFriendsAttribute()
    {
        if (!array_key_exists('friends', $this->relations)) {
            $this->setRelation('friends', $this->friendsOfMine->merge($this->friendsOf));
        }
        return $this->getRelation('friends');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }
    
    public function isOnline(): bool
    {
        return Cache::has('is-user-online' . $this->id);
    }
}
