<?php
namespace App\Services\TicTacToe;

use App\Models\Match;
use App\Repositories\MatchRepository;

class Winner
{

    /**
     * Verify have a winner, if yes register
     *
     * @param $match
     * @param $position
     * @param $playedMove
     * @return App\Models\Match
     */
    public function verify($match, $position, $playedMove)
    {

        $checkWinner = new CheckWinner();

        if($checkWinner->check($match, $position, $playedMove)) {
            $match = $this->setWinner($match, $playedMove);
        }

        return $match;

    }

    /**
     * Made the winner changed
     *
     * @param $match
     * @param $playedMove
     * @return App\Models\Match
     */
    private function setWinner($match, $playedMove)
    {
        $repository = new MatchRepository();
        return $repository->winner($match->id, $playedMove);
    }

}