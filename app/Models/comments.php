<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_id',
        'user_id',
        'comment_text',
        'rating',
        'likes',
        'dislikes',
        'is_reported'
    ];

    public function content()
    {
        return $this->belongsTo(contents::class, 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }



    public function reports()
    {
        return $this->hasMany(reports::class);
    }

    public function scopeReported($query)
    {
        return $query->where('is_reported', true);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'comment_id')->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->hasMany(Likes::class, 'comment_id')->where('type', 'dislike');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->dislikes()->count();
    }


}
