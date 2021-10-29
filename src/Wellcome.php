<?php declare(strict_types=1);

namespace Mrkrash\TicTacToe;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Wellcome
{
    public function __invoke(): ResponseInterface
    {
        return new JsonResponse([
            'message' => 'TicTacToe Example Backend',
            'status' => 'No Player',
        ]);
    }

    public function newMatch(): ResponseInterface
    {
        $match = new GameMatch;

        $_SESSION['matchs'][$match->getUuid()] = serialize($match);

        return new JsonResponse([
            'match_id' => $match->getUuid()
        ]);
    }

    public function playerMove(ServerRequestInterface $request): ResponseInterface
    {
        if (!isset($_SESSION['matchs'])) {
            return new JsonResponse([
                'reason_phrase' => 'No Game Started',
                'status_code' => 406,
            ], 406);
        }
        $params = $request->getParsedBody();
        if (!isset($params['uuid']) || !isset($_SESSION['matchs'][$params['uuid']])) {
            return new JsonResponse([
                'reason_phrase' => 'Game ID Not Supplied or Recognized',
                'status_code' => 406,
            ], 406);
        }
        if (!isset($params['player']) && !isset($params['move'])) {
            return new JsonResponse([
                'reason_phrase' => 'Malformed Request',
                'status_code' => 406,
            ], 406);
        }
        $match = unserialize($_SESSION['matchs'][$params['uuid']]);
        if (!empty($match->getWinner())) {
            return new JsonResponse([
                'reason_phrase' => "This match has ended. Player {$match->getWinner()} has win!!",
                'status_code' => 406,
            ], 406);
        }

        $match->playerMove($params['player'], $params['move']);
        $_SESSION['matchs'][$params['uuid']] = serialize($match);

        return new JsonResponse([
            'table' => $match->getTable(),
            'last_player' => $match->getLastPlayer(),
            'message' => $match->getMessage(),
            'winner' => $match->getWinner(),
        ]);
    }
}
