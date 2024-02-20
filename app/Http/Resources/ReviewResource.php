<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
                "user_id" => $this->user_id,
                "course_id" => $this->course_id,
                "rating" => $this->rating,
                "note" => $this->note,
                "created_at" => date(getDateTimeEnv(), strtotime($this->created_at)),
                "updated_at" => date(getDateTimeEnv(), strtotime($this->updated_at))
            ]
        ];
    }
}
