<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = "chapters";

    protected $casts = [
        "created_at" => "datetime:d/m/Y H:i",
        "updated_at" => "datetime:d/m/Y H:i",
    ];

    protected $fillable = [
        "name", "course_id"
    ];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class,"chapter_id","id");
    }
}
