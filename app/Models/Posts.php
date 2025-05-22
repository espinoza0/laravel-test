<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'user_id'];

    // public function comments()
    // {
    //     return $this->belongsTo(Comments::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
