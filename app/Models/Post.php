<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $fillable = ['title','slug','excerpt','body','featured_image','user_id','published_at'];
    public function user() { return $this->belongsTo(User::class); }
}
