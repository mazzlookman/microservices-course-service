<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
                "name" => $this->name,
                "content" => $this->content,
                "chapter_id" => $this->chapter_id,
                "created_at" => date("d/m/Y H:i", strtotime($this->created_at)),
                "updated_at" => date("d/m/Y H:i", strtotime($this->updated_at))
            ]
        ];
    }
}
