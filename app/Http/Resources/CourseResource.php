<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
                "name" => $this->name,
                "certificate" => $this->certificate,
                "thumbnail" => $this->thumbnail,
                "type" => $this->type,
                "status" => $this->status,
                "price" => $this->price,
                "level" => $this->level,
                "description" => $this->description,
                "mentor_id" => $this->mentor_id,
                "created_at" => date(dateTimeFormat(), strtotime($this->created_at)),
                "updated_at" => date(dateTimeFormat(), strtotime($this->updated_at))
            ]
        ];
    }
}
