<?php
namespace Tests\Services\TicTacToe;

use App\Services\TicTacToe\Winner;
use Tests\TestCase;
use App\Models\Match;
use App\Models\Move;
class WinnerTest extends TestCase
{

    /**
     * Test to pass by the code and not change to win
     */
    public function testVerifyToNotWin()
    {

        $match = $this->createMatch();
        foreach([0, 1, 2, 3, 4, 5, 6, 7, 8] as $position) {
            $this->createMove($position, $match->id);
        }

        $winner = new Winner();
        $winner->verify($match, 0, 1);

        $matchFound = Match::find($match->id);

        $this->assertEquals(0, $matchFound->winner);

    }

    /**
     * Test to pass by the code and change to winner.
     */
    public function testVerifyToWin()
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

        $winner = new Winner();
        $winner->verify($match, $position, 1);

        $matchFound = Match::find($match->id);

        $this->assertEquals(1, $matchFound->winner);

    }

}