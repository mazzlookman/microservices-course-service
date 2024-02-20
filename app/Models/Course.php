<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";

    protected $casts = [
        "created_at" => "datetime:Y-m-d H:i:s",
        "updated_at" => "datetime:Y-m-d H:i:s"
    ];

    protected $guarded = ["created_at", "updated_at"];

    public function Mentor()
    {
        return $this->belongsTo(Mentor::class,"mentor_id","id");
    }

    public function Chapters()
    {
        return $this->hasMany(Chapter::class,"course_id","id");
    }

    public function ImageCourses()
    {
        return $this->hasMany(ImageCourse::class,"course_id","id")
            ->orderBy("id", "desc");
    }
}
