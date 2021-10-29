<?php declare(strict_types=1);
namespace Mrkrash\TicTacToe;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GameMatchTest extends TestCase
{
    public function testCanBeStartedNewMatch(): void
    {
        $match = new GameMatch;
        $this->assertTrue(Uuid::isValid($match->getUuid()));
    }

    public function testIsValidPlayer(): void
    {
        $match = new GameMatch;
        $match->playerMove("R", "T0");
        $this->assertEquals($match->getMessage(), GameMatch::PLAYER_UNKNOWN);
    }

    public function testPlayerCanMove(): void
    {
        $match = new GameMatch;
        $match->playerMove("2", "T0");
        $this->assertIsArray($match->getTable());
    }

    public function testPlayerCannotMoveTwice(): void
    {
        $match = new GameMatch;
        $match->playerMove("2", "T0");
        $match->playerMove("2", "C1");
        $this->assertEquals($match->getMessage(), GameMatch::NOT_YOUR_TURN);
    }

    public function testPlayerSendValidMove(): void
    {
        $match = new GameMatch;
        $match->playerMove("1", "T4");
        $this->assertEquals($match->getMessage(), GameMatch::INVALID_MOVE);
    }
}
