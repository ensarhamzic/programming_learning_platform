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

    public function isImage()
    {
        return $this->contentType->name === 'image';
    }

    public function isVideo()
    {
        return $this->contentType->name === 'video';
    }

    public function isPdf()
    {
        return $this->contentType->name === 'pdf';
    }

    public function isDocument()
    {
        return $this->contentType->name === 'document';
    }

    public function isPresentation()
    {
        return $this->contentType->name === 'presentation';
    }

    public function isZip()
    {
        return $this->contentType->name === 'zip';
    }

    public function isLink()
    {
        return $this->contentType->name === 'link';
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getCheckQuestion()
    {
        return $this->questions()->where('type', 'check')->first();
    }
}
