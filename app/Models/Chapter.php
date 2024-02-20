<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = "chapters";

    protected $casts = [
        "created_at" => "datetime:Y-m-d H:i:s",
        "updated_at" => "datetime:Y-m-d H:i:s"
    ];

    protected $fillable = [
        "name", "course_id"
    ];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class,"chapter_id","id");
    }
}
