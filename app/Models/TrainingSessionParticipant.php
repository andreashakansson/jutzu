<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSessionParticipant extends Model
{
    use HasFactory;

    protected $fillable = ['training_session_id', 'user_id', 'is_participant'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
