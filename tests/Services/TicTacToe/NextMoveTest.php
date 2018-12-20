<?php
namespace Tests\Services\TicTacToe;

use App\Services\TicTacToe\NextMove;
use Tests\TestCase;

class NextMoveTest extends TestCase
{

    public function testNextMoveAreX()
    {

        $matchInit = $this->createMatch();
        $matchInit->next = 1;
        $matchInit->save();

        $expectedMove = 2;

        $next = new NextMove();
        $match = $next->change($matchInit);
        $this->assertEquals($expectedMove, $match->next);

    }

    public function testNextMoveAreO()
    {
        $matchInit = $this->createMatch();
        $expectedMove = 1;

        $next = new NextMove($matchInit);
        $match = $next->change($matchInit);
        $this->assertEquals($expectedMove, $match->next);

    }

}