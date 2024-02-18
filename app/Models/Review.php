<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    protected $guarded = [
        "created_at", "updated_at"
    ];

    public function Course()
    {
        return $this->belongsTo(Course::class,"course_id","id");
    }
}
