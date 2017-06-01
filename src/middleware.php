<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//JWT Middleware

// $app->add(new \Slim\Middleware\JwtAuthentication([
//     "secret" => "my_secret_api_key",
//     // "cookie" => "nekot",
//     "path" => ["/"],
//     "passthrough" => ["/auth/attempt", "/users/create", "/users/all", "/questions", "/scores"],
//     "secure" => false,
//     "callback" => function ($request, $response, $arguments) use ($container) {
//         $container["jwt"] = $arguments["decoded"];
//     },
//     "error" => function ($request, $response, $arguments) {
//         $data["status"] = "error";
//         $data["message"] = $arguments["message"];
//         return $response->withJson($data, 401);
//     }
// ]));
$app->add(new \Tuupola\Middleware\Cors([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "OPTIONS", "DELETE"],
    "headers.allow" => ["Content-Type", "Authorization", "X-Requested-With"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));
