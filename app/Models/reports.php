<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reports extends Model
{
    use HasFactory;
    protected $fillable = ['comment_id', 'user_id', 'reason'];


    public function comment()
    {
        return $this->belongsTo(comments::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
