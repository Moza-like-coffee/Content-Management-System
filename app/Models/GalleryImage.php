<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model {
    protected $fillable = ['gallery_id','path','thumb_path','caption','order'];
    public function gallery() { return $this->belongsTo(Gallery::class); }
}