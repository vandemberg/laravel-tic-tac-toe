<?php
namespace Tests\Support;

use App\Models\Match;

Trait CreateMatch
{
    /**
     * Create a basic match
     *
     * @return Match
     */
    public function createMatch() : Match
    {
        return Match::create([
            'name'   => 'Match 1',
            'next'   => 2,
            'winner' => 0
        ]);
    }

}