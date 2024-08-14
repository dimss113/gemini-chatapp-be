<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assistant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'user_id',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * Get all of the chats for the Assistant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'assistant_id', 'id');
    }
    
    /**
     * Get the users that owns the Assistant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
