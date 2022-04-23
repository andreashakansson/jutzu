<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'type', 'notes', 'created_by', 'created_at', 'updated_at'];

    protected $dates = ['date'];

    protected $appends = ['dateHuman', 'typeHuman', 'userIsParticipant', 'participantUsers'];

    public function getDateHumanAttribute()
    {
        return $this->date->format('D d M Y');
    }

    public function getTypeHumanAttribute()
    {
        return config('project.trainingSession.types.' . $this->type);
    }

    public function getUserIsParticipantAttribute(): ?bool
    {
        $participant = $this->participants()->where('user_id', Auth::user()->id)->first();
        if ($participant) {
            return $participant->is_participant == 1;
        }
        return null;
    }

    public function getParticipantUsersAttribute(): array
    {
        $participants = $this->participants()->where('is_participant', true)->get();
        $out = [];
        foreach ($participants as $participant) {
            $out[] = $participant->user->firstname;
        }
        return $out;
    }

    public function techniques(): HasMany
    {
        return $this->hasMany(TrainingSessionTechnique::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(TrainingSessionParticipant::class);
    }
}
