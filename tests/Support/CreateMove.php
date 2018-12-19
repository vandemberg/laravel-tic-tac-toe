<?php
namespace Tests\Support;

use App\Models\Move;

Trait CreateMove
{
    public function createMove(int $position, int $matchId) : Move
    {
        return Move::create([
            'position' => $position,
            'match_id' => $matchId,
            'value' => 0
        ]);
    }
}