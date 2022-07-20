<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'academy_id',
        'name',
        'start_at',
        'end_at',
        'description',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['start_at', 'end_at'];

    public function getStartAtHumanAttribute()
    {
        $date = ucwords($this->start_at->translatedFormat('l jS F'));
        $date .= ' kl. ' . $this->start_at->format('H:i');
        return $date;
    }

    public function getEndAtHumanAttribute()
    {
        $date = ucwords($this->end_at->translatedFormat('l jS F'));
        $date .= ' ' . __('at') . ' ' . $this->end_at->format('H:i');
        return $date;
    }
}
