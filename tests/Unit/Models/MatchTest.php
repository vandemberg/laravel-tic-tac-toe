<?php
namespace Tests\Unit\Models;

use App\Models\Match;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class MatchTest extends TestCase
{

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
    public function testMoves()
    {

        $match = $this->createMatch();
        $matchId = $match->id;

        $positions = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        foreach($positions AS $position) {
            $this->createMove($position, $matchId);
        }

        $match->refresh();

        $this->assertInstanceOf(Collection::class, $match->moves);

    }

}