<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'JMBG';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'JMBG',
        'role_id',
        'name',
        'surname',
        'gender',
        'username',
        'birth_place',
        'birth_country',
        'birth_date',
        'mobile_number',
        'image_url',
        'email',
        'password',
        'approved'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isApproved()
    {
        return boolval($this->approved);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_JMBG', 'JMBG');
    }

    public function ownsCourse($course)
    {
        return $this->courses->contains($course);
    }

    public function attends()
    {
        return $this->hasMany(CourseAttend::class);
    }

    public function attendsCourse($course)
    {
        $attend = $this->attends->where('course_id', $course->id)->first();
        return $attend ? true : false;
    }

    public function completedContents()
    {
        return $this->hasMany(ContentComplete::class);
    }

    public function completedContent($content)
    {
        $complete = $this->completedContents->where('content_id', $content->id)->first();
        return $complete ? true : false;
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function doneTest($course)
    {
        $rawAnswers = $this->answers;
        $allAnswers = [];
        foreach ($rawAnswers as $answer) {
            array_push($allAnswers, $answer->answer);
        }
        $allAnswers = Arr::flatten($allAnswers);
        $allQuestions = $course->questions();
        $allQuestionAnswers = [];
        foreach ($allQuestions as $question) {
            array_push($allQuestionAnswers, $question->answers);
        }
        $allQuestionAnswers = Arr::flatten($allQuestionAnswers);

        $allQuestions = collect($allQuestions);
        $allQuestionsIds = $allQuestions->pluck('id')->toArray();

        $allQuestionAnswers = collect($allQuestionAnswers);
        $allQuestionAnswersIds = $allQuestionAnswers->pluck('id')->toArray();


        foreach ($allAnswers as $answer) {
            if (in_array($answer->id, $allQuestionAnswersIds) && $answer->question->type == 'test' && $answer->question->content->section->course->id == $course->id) {
                return true;
            }
        }

        return false;
    }

    public function testPoints($course)
    {
        $questions = collect($course->questions())->where('type', 'test');
        $questionsIds = $questions->pluck('id');

        $rawAnswers = $this->answers;
        $allAnswers = [];
        foreach ($rawAnswers as $answer) {
            if ($answer->answer->question->type == "test")
                array_push($allAnswers, $answer->answer);
        }
        $allAnswers = Arr::flatten($allAnswers);
        $allAnswers = collect($allAnswers);
        $userAnswers = $allAnswers->whereIn('question_id', $questionsIds);
        $level = $userAnswers->first()->question->level;

        $questions = $questions->where('level', $level);

        $points = 0;
        foreach ($questions as $question) {
            if (in_array($question->getCorrectAnswer()->id, $userAnswers->pluck('id')->toArray()))
                if ($question->getCorrectAnswer()->userUsedHelp($this->JMBG))
                    $points += 0.5;
                else
                    $points += 1;
        }

        return $points;
    }

    public function testLevel($course)
    {
        $questions = collect($course->questions())->where('type', 'test');
        $questionsIds = $questions->pluck('id');
        $rawAnswers = $this->answers;
        $allAnswers = [];
        foreach ($rawAnswers as $answer) {
            if ($answer->answer->question->type == "test")
                array_push($allAnswers, $answer->answer);
        }
        $allAnswers = Arr::flatten($allAnswers);
        $allAnswers = collect($allAnswers);
        $userAnswers = $allAnswers->whereIn('question_id', $questionsIds);
        $level = $userAnswers->first()->question->level;

        return $level;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
