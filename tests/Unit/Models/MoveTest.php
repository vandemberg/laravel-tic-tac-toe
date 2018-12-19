<?php
namespace Tests\Unit\Models;

use App\Models\Match;
use App\Models\Move;
use Tests\TestCase;

class MoveTest extends TestCase
{

    /**
     * Test to check if the Model connect with de Database tables
     */
    public function testCreate()
    {

        $match = $this->createMatch();

        $matchId = $match->id;
        $position = 0;

        $move = $this->createMove($position, $matchId);
        $moveId = $move->id;

        $moveFind = Move::find($moveId);
        $moveFindId = $moveFind->id;

        $this->assertNotEmpty($moveFind);
        $this->assertInstanceOf(Move::class, $moveFind);
        $this->assertEquals($moveFindId, $moveId);

    }

    /**
     * Test to check if the Model get the relationship correctly
     */
    public function testMatch()
    {
        $match = $this->createMatch();

        $matchId = $match->id;
        $position = 0;

        $move = $this->createMove($position, $matchId);
        $this->assertInstanceOf(Match::class, $move->match);

    }
}