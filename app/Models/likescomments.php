<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likescomments extends Model
{
    use HasFactory;
    protected $fillable = ['content_id', 'user_id', 'type'];


    public function contents()
    {
        return $this->belongsTo(contents::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
