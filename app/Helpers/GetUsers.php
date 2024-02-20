<?php

use Illuminate\Support\Facades\Http;

function getUserById(int $userId)
{
    try {
        $url = sprintf("%s/users/%d", env("USER_SERVICE_URL"), $userId);
        $res = Http::timeout(5)->get($url);

        // response data sesuai dengan response dari service yang dipanggil (dikasus ini: user-service)
        return $res->json();

    } catch (Exception $exception) {
        return [
            "code" => 500,
            "status" => "Internal Server Error",
            "errors" => [
                "message" => $exception->getMessage()
            ]
        ];
    }
}

function GetUserByIds(array $userIds = [])
{
    $url = sprintf("%s/users", env("USER_SERVICE_URL"));

    try {
        if (count($userIds) === 0) {
            return [
                "code" => 200,
                "status" => "OK",
                "data" => []
            ];
        }

        $res = Http::timeout(10)->get(
            $url, ["id" => $userIds],
        );

        var_dump($res);

        $data = $res->json();
        $data["http_code"] = $res->status();

        return $data;

    } catch (\Throwable $throwable) {
        return [
            "code" => 500,
            "status" => "Internal Server Error",
            "errors" => [
                "message" => "Service user unavailable"
            ]
        ];
    }
}
