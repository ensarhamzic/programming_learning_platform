<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentComplete extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_JMBG',
        'content_id'
    ];
}
