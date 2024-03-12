<?php

use Illuminate\Support\Facades\Http;

function postOrder($request): array
{
    try {
        $url = env("ORDER_PAYMENT_SERVICE_URL") . "/api/orders";
        $res = Http::post($url, $request);

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

function getUserById(int $userId): array
{
    try {
        $url = sprintf("%s/api/users/%d", env("USER_SERVICE_URL"), $userId);
        $res = Http::timeout(5)->get($url);

        // response data sesuai dengan response dari service yang dipanggil (dikasus ini: user-service)
        return $res->json();

    } catch (Exception $exception) {
        return [
            "code" => 500,
            "status" => "Internal Server Error",
            "errors" => [
                "message" => $exception->getMessage(),
                "line" => $exception->getLine(),
                "file" => $exception->getFile()
            ]
        ];
    }
}

function getUserByIds(array $userIds = []): array
{
    $url = sprintf("%s/api/users", env("USER_SERVICE_URL"));

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

function dateTimeFormat(): string
{
    return "Y-m-d H:i:s";
}
