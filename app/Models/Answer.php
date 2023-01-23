<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userUsedHelp($userJMBG)
    {
        $questionAnswer = QuestionAnswer::where('answer_id', $this->id)
            ->where('user_JMBG', $userJMBG)
            ->first();

        return $questionAnswer->help_used;
    }
}
