<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'user_id',
        'assistant_id',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * Get the users that owns the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the assistants that owns the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assistants(): BelongsTo
    {
        return $this->belongsTo(Assistant::class, 'assistant_id', 'id');
    }

    /**
     * Get all of the messages for the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }
}
