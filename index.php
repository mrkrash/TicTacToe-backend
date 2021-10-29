<?php declare(strict_types=1);

namespace Mrkrash\TicTacToe;

use Throwable;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

(static function (): void {
    require __DIR__ . '/vendor/autoload.php';

    try {
        $app = App::bootstrap();

        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        $response = $app->handle($request);
    } catch (Throwable $exception) {
        $response = new JsonResponse(['error' => exception_to_array($exception)], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    (new SapiEmitter)->emit($response);
})();
