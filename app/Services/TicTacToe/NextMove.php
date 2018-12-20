<?php
namespace App\Services\TicTacToe;

use App\Models\Match;
use App\Repositories\MatchRepository;

class NextMove
{

    /**
     * Change the next player, 2 to 1. And 1 to 2. 2 = O and 1 = X
     *
     * @param Match $match
     * @return Match
     */
    public function change(Match $match)
    {
        $repository = new MatchRepository();

        if ( $match->next == 1) {
            $match = $repository->nextMove($match->id, 2);
        } else {
            $match = $repository->nextMove($match->id, 1);
        }

        return $match;
    }

}