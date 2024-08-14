<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Get all of the chats for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id', 'id');
    }

    /**
     * Get all of the assistants for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assistants(): HasMany
    {
        return $this->hasMany(Assistant::class, 'user_id', 'id');
    }

}
