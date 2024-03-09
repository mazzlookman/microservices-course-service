<?php

namespace App\Http\Controllers\Response;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ControllerResponses
{
    public static function internalServerError(string $message)
    {
        return [
            "code" => 500,
            "status" => "Internal Server Error",
            "errors" => [
                "message" => $message
            ]
        ];
    }
    public static function errorFromOtherServiceResponse(array $data)
    {
        return [
            "code" => $data["code"],
            "status" => $data["status"],
            "errors" => [
                "message" => $data["errors"]["message"]
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

    public static function getAllModelResponse(mixed $collection)
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
