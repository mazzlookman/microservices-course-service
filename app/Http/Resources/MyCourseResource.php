<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "code" => 201,
            "status" => "Created",
            "data" => [
                "id" => $this->id,
                "course_id" => $this->course_id,
                "user_id" => $this->user_id,
                "created_at" => date(getDateTimeEnv(), strtotime($this->created_at)),
                "updated_at" => date(getDateTimeEnv(), strtotime($this->updated_at))
            ]
        ];
    }
}
