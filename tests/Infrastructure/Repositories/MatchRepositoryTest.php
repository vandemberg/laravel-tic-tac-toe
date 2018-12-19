<?php

namespace Tests\Infrastructure\Repositories;

use App\Models\Match;
use App\Repositories\MatchRepository;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class MatchRepositoryTest extends TestCase
{

    /**
     * Init a data creating one match and one move
     */
    private function init()
    {
        $match = $this->createMatch();
        $this->createMove(1, $match->id);
    }

    /**
     * Test if the repository create a match correctly
     */
    public function testCreate()
    {

        $repository = new MatchRepository();

        $match = $repository->create([
            'name' => 'Match',
            'next' => 1,
            'winner' => 0
        ]);

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals('Match', $match->name);
        $this->assertEquals(1, $match->next);
        $this->assertEquals(0, $match->winner);

    }

    /**
     * test if repository can list all matchs
     */
    public function testAll()
    {
        $this->init();
        $repository = new MatchRepository();
        $list = $repository->all();
        $this->assertInstanceOf(Collection::class, $list);
    }

    /**
     * test if a match can be updated by the repository
     */
    public function testUpdate()
    {
        $this->init();
        $match = Match::all()->first();
        $newData = [
            'next' => 2,
            'winner' => 1
        ];

        $repository = new MatchRepository();
        $matchChanged= $repository->update($newData, $match->id);

        $this->assertInstanceOf(Match::class, $matchChanged);
        $this->assertEquals(2, $matchChanged->next);
        $this->assertEquals(1, $matchChanged->winner);
    }

    /**
     * test if the repository can find a match by the id
     */
    public function testFindById()
    {
        $this->init();
        $match = Match::all()->first();

        $repository = new MatchRepository();
        $matchFound = $repository->findById($match->id);

        $this->assertInstanceOf(Match::class, $matchFound);
        $this->assertEquals($match->id, $matchFound->id);

    }

    /**
     * Test if a repository can delete a match
     */
    public function testDelete()
    {
        $this->init();
        $match = Match::all()->first();

        $repository = new MatchRepository();
        $repository->delete($match->id);

        $matchSearched = Match::find($match->id);

        $this->assertNull($matchSearched );

    }

}