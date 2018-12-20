<?php
namespace Tests\Services\TicTacToe;

use App\Models\Math;
use App\Models\Move;
use App\Services\TicTacToe\CheckWinner;
use Tests\TestCase;

class CheckWinnerTest extends TestCase
{
    /**
     * Test to pass by the code and not change to win
     */
    public function testToNotWin()
    {

        $match = $this->createMatch();
        foreach([0, 1, 2, 3, 4, 5, 6, 7, 8] as $position) {
            $this->createMove($position, $match->id);
        }

        $winner = new CheckWinner();
        $result = $winner->check($match, 0, 1);
        $this->assertNotTrue($result);

    }

    /**
     * Test to pass by the code and change to winner.
     */
    public function testToWin()
    {
        $match = $this->createMatch();

        foreach([0, 1, 2, 3, 4, 5, 6, 7, 8] as $position) {
            $this->createMove($position, $match->id);
        }

        foreach([0, 1, 2] as $position) {

            $move = Move::where('position', $position)
                ->where("match_id", $match->id)
                ->first();

            $move->value = 1;
            $move->save();

        }

        $winner = new CheckWinner();
        $result = $winner->check($match, $position, 1);

        $this->assertTrue($result);

    }
}