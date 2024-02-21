<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCourseResource extends JsonResource
{
    public function __construct($resource,
                                public int $statusCode = 200,
                                public string $statusText = "OK")
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->statusCode,
            "status" => $this->statusText,
            "data" => [
                "id" => $this->id,
                "course_id" => $this->course_id,
                "user_id" => $this->user_id,
                "created_at" => date(dateTimeFormat(), strtotime($this->created_at)),
                "updated_at" => date(dateTimeFormat(), strtotime($this->updated_at))
            ]
        ];
    }
}
