<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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

    public function questions()
    {
        $sections = $this->sections;
        // for every section, get content
        $contents = [];
        foreach ($sections as $section) {
            $contents[] = $section->contents;
        }
        // for every content, get questions
        $questions = [];
        foreach ($contents as $content) {
            foreach ($content as $c) {
                $questions[] = $c->questions;
            }
        }
        // $questions is now a 2D array, so we need to flatten it
        $questions = Arr::flatten($questions);

        return $questions;
    }

    public function attends()
    {
        return $this->hasMany(CourseAttend::class);
    }
}
