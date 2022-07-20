<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academy extends Model
{
    use HasFactory;

    public function trainingSessions(): HasMany
    {
        return $this->hasMany(TrainingSession::class);
    }

    public function techniques(): HasMany
    {
        return $this->hasMany(Technique::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(AcademyEvent::class);
    }
}
