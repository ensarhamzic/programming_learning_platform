<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_JMBG',
        'title',
        'description',
        'image',
        'active',
        'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_JMBG', 'JMBG');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function attends()
    {
        return $this->hasMany(CourseAttend::class);
    }
}
