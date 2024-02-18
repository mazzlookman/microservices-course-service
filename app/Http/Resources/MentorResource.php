<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
{

//    public static $wrap = "mentor";

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
                "profile" => $this->profile,
                "email" => $this->email,
                "profession" => $this->profession,
            ]
        ];
    }
}
