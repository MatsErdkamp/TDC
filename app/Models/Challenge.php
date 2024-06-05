<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'date',
        'prompt',
        'winner',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function winnerSubmission()
    {
        return $this->belongsTo(Submission::class, 'winner');
    }
}
