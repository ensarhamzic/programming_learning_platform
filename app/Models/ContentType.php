<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
