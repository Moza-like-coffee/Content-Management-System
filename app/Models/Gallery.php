<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
    protected $fillable = ['title','slug','description','user_id'];
    public function images() { return $this->hasMany(GalleryImage::class); }
    public function user() { return $this->belongsTo(User::class); }
}
