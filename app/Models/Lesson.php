<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = "lessons";

    protected $casts = [
        "created_at" => "datetime:d/m/Y H:i",
        "updated_at" => "datetime:d/m/Y H:i",
    ];

    protected $fillable = [
        "name", "content", "chapter_id"
    ];
}
