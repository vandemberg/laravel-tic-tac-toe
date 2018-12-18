<?php
namespace Tests\Unit\Models;

use App\Models\Match;
use App\Models\Move;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class MoveTest extends TestCase
{

    use DatabaseTransactions;

    private function createMatch() : Match
    {
        return Match::create([
            'name'   => 'Match 1',
            'next'   => 2,
            'winner' => 0
        ]);
    }

    private function createMove(int $position, int $matchId) : Move
    {
        return Move::create([
            'position' => $position,
            'match_id' => $matchId,
            'value' => 0
        ]);
    }

    /**
     * Test to check if the Model connect with de Database tables
     */
    public function testCreate()
    {

        $match = $this->createMatch();
        $matchId = $match->id;
        $findMatch = Match::find($matchId);

        $this->assertNotEmpty($findMatch);
        $this->assertEquals($findMatch->id, $matchId);

    }

    /**
     * Test to check if the Model get the relationship correctly
     */
    public function testMatch()
    {

        $match = $this->createMatch();
        $matchId = $match->id;

        $positions = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        foreach($positions AS $position) {
            $this->createMove($position, $matchId);
        }

        $match->refresh();

        $this->assertInstanceOf(Collection::class, $match->moves());

    }

}