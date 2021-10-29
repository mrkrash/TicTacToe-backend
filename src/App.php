<?php declare(strict_types=1);

namespace Mrkrash\TicTacToe;

use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use Middlewares\JsonPayload;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var Router
     */
    private $router;

    public static function bootstrap(): self
    {
        $responseFactory = new ResponseFactory();
        $strategy = new JsonStrategy($responseFactory);
        $router = (new Router)->setStrategy($strategy);
        $app = new self($router);

        return $app;
    }

    private function mapRoute(Router $router): Router
    {
        $router->map('GET', '/', Wellcome::class);
        $router->map('PATCH', '/move', [Wellcome::class, 'playerMove']);
        $router->map('POST', '/new', [Wellcome::class, 'newMatch']);

        return $router;
    }

    public function __construct(Router $router)
    {
        session_start();
        if (!isset($_SESSION['matchs'])) {
            $_SESSION['matchs'] = [];
        }
        $router->middleware(new JsonPayload());
        $this->router = $this->mapRoute($router);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->router->dispatch($request);
        
        return $response;
    }
}
