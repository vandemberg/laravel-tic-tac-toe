<?php
namespace App\Repositories;

use App\Models\Move;

class MoveRepository extends AbstractRepository
{

    public function model()
    {
        return Move::class;
    }

    public function changeByPosition($matchId, $position, $value)
    {
        $move = $this
            ->model->where("match_id", $matchId)
            ->where("position", $position)
            ->first();

        $move->value = $value;
        $move->save();

        return $move;

    }

}