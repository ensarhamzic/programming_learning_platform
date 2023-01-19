<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type_id',
        'title',
        'source',
    ];

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
