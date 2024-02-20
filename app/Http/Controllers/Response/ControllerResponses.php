<?php

namespace App\Http\Controllers\Response;

use Illuminate\Database\Eloquent\Collection;

class ControllerResponses
{
    public static function errorFromUserServiceResponse(array $user)
    {
        return [
            "code" => $user["code"],
            "status" => $user["status"],
            "errors" => [
                "message" => $user["errors"]["message"]
            ]
        ];
    }

    public static function conflictResponse(string $message)
    {
        return [
            "code" => 409,
            "status" => "Conflict",
            "errors" => [
                "message" => $message
            ]
        ];
    }

    public static function notFoundResponse(string $model)
    {
        return [
            "code" => 404,
            "status" => "Not Found",
            "errors" => [
                "message" => $model ." not found"
            ]
        ];
    }

    public static function getAllModelResponse(Collection $collection)
    {
        return [
            "code" => 200,
            "status" => "OK",
            "data" => $collection
        ];
    }

    public static function deletedResponse(string $model)
    {
        return [
            "code" => 200,
            "status" => "OK",
            "data" => [
                "message" => $model ." has been deleted"
            ]
        ];
    }

}
