<?php
namespace App\Services\TicTacToe;

class CheckWinner
{
    private $winnerMoves = [

        [0, 1, 2],
        [0, 3, 6],
        [0, 4, 8],

        [1, 4, 7],

        [2, 5, 8],
        [2, 4, 6],

        [3, 4, 5],

        [6, 7, 8]

    ];

    /**
     * Find if the player winner
     *
     * @param $match
     * @param $position
     * @param $playedMove
     * @return bool
     */
    public function check($match, $position, $playedMove)
    {

        $board = $match->moves->pluck('value');

        foreach($this->winnerMoves as $winnerMove) {

            if(in_array($position, $winnerMove)) {

                $moveToWin = 0;

                foreach($winnerMove as $winnerPosition) {


                    if($board[$winnerPosition] == $playedMove) {
                        $moveToWin++;
                    } else {
                        break;
                    }

                    if($moveToWin == 3) {
                        return true;
                    }

                }

            }
        }

        return false;

    }

}