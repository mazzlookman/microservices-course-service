<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "code" => 200,
            "status" => "OK",
            "data" => [
                "id" => $this->id,
                "image" => $this->image,
                "course_id" => $this->course_id,
                "created_at" => date(getDateTimeEnv(), strtotime($this->created_at)),
                "updated_at" => date(getDateTimeEnv(), strtotime($this->updated_at))
            ]
        ];
    }
}
