<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_JMBG',
        'rating'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
