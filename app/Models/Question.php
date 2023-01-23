<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'text',
        'level',
        'type',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getCorrectAnswer()
    {
        return $this->answers()->where('is_correct', true)->first();
    }
}
