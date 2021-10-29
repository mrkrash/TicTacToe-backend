<?php declare(strict_types=1);

namespace Mrkrash\TicTacToe;

use JsonSerializable;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class GameMatch implements JsonSerializable
{
    private $player1 = "1";
    private $player2 = "2";

    /**
     * @var String
     */
    private $uuid;

    /**
     * @var Array
     */
    private $table = [
        'T' => ['', '', ''],
        'C' => ['', '', ''],
        'D' => ['', '', ''],
    ];

    /**
     * Player thath have moved
     * @var String
     */
    private $last_player;

    /**
     * @var Array
     */
    private $status = [
        'message' => null,
        'winner' => null,
    ];
    
    public function __construct()
    {
        $this->uuid = (Uuid::uuid4())->toString();
    }

    public function getLastPlayer(): string
    {
        return $this->last_player;
    }

    public function getMessage(): ?string
    {
        return $this->status['message'];
    }

    public function getTable(): array
    {
        return $this->table;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getWinner(): ?string
    {
        return $this->status['winner'];
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'match' => $this->match,
            'player' => $this->player,
            'table' => $this->table,
        ];
    }

    public function playerMove(string $player, string $move)
    {
        $row = substr($move, 0, 1);
        $col = (int) substr($move, 1, 1);

        if ($this->isPlayerValid($player) &&
            $this->isPlayerTurn($player) &&
            $this->isMoveValid($row, $col)
        ) {
            $this->status['message'] == null;
            $this->table[$row][$col] = $player;
            $this->last_player = $player;
            $this->isWinner($player);
        }
    }

    private function isMoveValid(string $row, int $col): bool
    {
        if (($row === 'T' || $row === 'C' || $row === 'D') &&
            ($col >= 0 && $col <= 2) &&
            empty($this->table[$row][$col])
        ) {
            return true;
        }
        $this->status['message'] = 'Invalid Move';
        return false;
    }

    private function isWinner(string $player): bool
    {
        if (($this->table['T'] == [$player, $player, $player]) ||
            ($this->table['C'] == [$player, $player, $player]) ||
            ($this->table['D'] == [$player, $player, $player]) ||
            ([$this->table['T'][0],$this->table['C'][0],$this->table['D'][0]] == [$player, $player, $player]) ||
            ([$this->table['T'][1],$this->table['C'][1],$this->table['D'][1]] == [$player, $player, $player]) ||
            ([$this->table['T'][2],$this->table['C'][2],$this->table['D'][2]] == [$player, $player, $player]) ||
            ([$this->table['T'][0],$this->table['C'][1],$this->table['D'][2]] == [$player, $player, $player]) ||
            ([$this->table['T'][2],$this->table['C'][1],$this->table['D'][0]] == [$player, $player, $player])
        ) {
            $this->status['winner'] = $player;
            $this->status['message'] = 'We have a Winner!!';
            return true;
        }
        return false;
    }

    private function isPlayerTurn(string $player): bool
    {
        if ($this->last_player !== $player) {
            return true;
        }
        $this->status['message'] = 'it\'s not your turn';
        return false;
    }

    private function isPlayerValid(string $player): bool
    {
        if ($player === $this->player1 || $player === $this->player2) {
            return true;
        }
        $this->status['message'] = 'Player Unknown';
        return false;
    }
}
