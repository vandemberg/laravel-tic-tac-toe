<?php
/**
 * Created by PhpStorm.
 * User: vandemberg
 * Date: 18/12/18
 * Time: 22:16
 */

namespace Tests\Infrastructure\Repositories;

use App\Models\Move;
use App\Repositories\MoveRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class MoveRepositoryTest extends TestCase
{

    /**
     * Init a data creating Matchs and Moves
     */
    private function init()
    {
        $match = $this->createMatch();
        foreach([1,2,3,4,5,6,7,8,9] as $position) {
            $this->createMove($position, $match->id);
        }
    }

    /**
     * Test if the repository create moves correctly
     */
    public function testCreate()
    {

        $repository = new MoveRepository();

        $match = $this->createMatch();

        $move = $repository->create([
            'value' => 0,
            'position' => 1,
            'match_id' => $match->id
        ]);

        $this->assertInstanceOf(Move::class, $move);
        $this->assertEquals(0, $move->value);
        $this->assertEquals(1, $move->position);
        $this->assertEquals($match->id, $move->match->id);

    }

    /**
     * test if repository can list all moves
     */
    public function testAll()
    {
        $this->init();
        $repository = new MoveRepository();
        $list = $repository->all();
        $this->assertInstanceOf(Collection::class, $list);
    }

    /**
     * test if a move can be updated by the repository
     */
    public function testUpdate()
    {
        $this->init();
        $move = Move::get()->first();
        $newData = ['value' => 2];

        $repository = new MoveRepository();
        $moveChanged = $repository->update($newData, $move->id);

        $this->assertInstanceOf(Move::class, $moveChanged);
        $this->assertEquals(2, $moveChanged->value);
        $this->assertEquals($moveChanged->id, $move->id);

    }

    /**
     * test if the repository can find a move by the id
     */
    public function testFindById()
    {
        $this->init();
        $move = Move::get()->first();

        $repository = new MoveRepository();
        $moveFound = $repository->findById($move->id);

        $this->assertInstanceOf(Move::class, $moveFound);
        $this->assertEquals($move->id, $moveFound->id);

    }

    /**
     * Test if a repository can delete a move
     */
    public function testDelete()
    {
        $this->init();
        $move = Move::get()->first();

        $repository = new MoveRepository();
        $repository->delete($move->id);

        $moveSearched = Move::find($move->id);

        $this->assertNull($moveSearched);

    }

}