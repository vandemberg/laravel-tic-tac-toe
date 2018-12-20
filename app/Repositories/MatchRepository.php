<?php
namespace App\Repositories;

use App\Models\Match;

class MatchRepository extends AbstractRepository
{

    public function model()
    {
        return Match::class;
    }

    public function winner($matchId, $win)
    {
        $match = $this->model
            ->where("id", $matchId)
            ->first();

        $match->winner = $win;
        $match->save();

        return $match;
    }

    public function nextMove($matchId, $next)
    {
        $match = $this->model
            ->where("id", $matchId)
            ->first();

        $match->next = $next;
        $match->save();

        return $match;
    }

}