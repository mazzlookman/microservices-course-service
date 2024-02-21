<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    protected $casts = [
        "created_at" => "datetime:Y-m-d H:i:s",
        "updated_at" => "datetime:Y-m-d H:i:s"
    ];

    protected $guarded = [
        "created_at", "updated_at"
    ];

    public function Course()
    {
        return $this->belongsTo(Course::class,"course_id","id");
    }
}
