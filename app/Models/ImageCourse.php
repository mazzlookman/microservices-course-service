<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCourse extends Model
{
    use HasFactory;

    protected $table = "image_courses";

    protected $hidden = [
        "created_at", "updated_at",
    ];

    protected $fillable = [
        "course_id", "image"
    ];
}
