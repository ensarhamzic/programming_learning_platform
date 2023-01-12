<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
