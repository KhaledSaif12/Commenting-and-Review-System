<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contents extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description'];

    public function comments()
    {
        return $this->hasMany(comments::class, 'content_id');
    }
    public function likes()
    {
        return $this->hasMany(likescomments::class, 'content_id')->where('type', 'like');
    }

    /**
     * Get all dislikes for the content.
     */
    public function dislikes()
    {
        return $this->hasMany(likescomments::class, 'content_id')->where('type', 'dislike');
    }
}
