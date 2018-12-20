<?php
namespace Tests\Services\Match;

use App\Models\Match;
use App\Services\Match\MatchUseCase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class MatchUseCaseTest extends TestCase
{

    /**
     * Test if the usecase service can create the tic tac toe
     */
    public function testCreate()
    {
        $useCase = new MatchUseCase();
        $matches = $useCase->addNewMatch();
        $match = $matches->last();

        $moves = $match->moves;
        $movesExpected = 9;

        $this->assertInstanceOf(Collection::class, $matches);
        $this->assertInstanceOf(Match::class, $match);
        $this->assertCount($movesExpected, $moves);

    }

    /**
     * Test if the usecase service can list all matches
     */
    public function testList()
    {

        $matchInit = $this->createMatch();
        $this->createMove(0, $matchInit->id);

        $useCase = new MatchUseCase();
        $matches = $useCase->list();

        $this->assertInstanceOf(Collection::class, $matches);

        foreach($matches as $match) {
            $this->assertNotEmpty($match->board);
        }

    }

    /**
     * Test if the usecase service registers when it's X's turn
     */
    public function testRegisterMoveWithX()
    {

        $matchInit = $this->createMatch();

        $nextMove = 1;
        $currentMove = 2;

        foreach([0, 1, 2, 3, 4, 5, 6, 7, 8, 9] as $posistion) {
            $this->createMove($posistion, $matchInit->id);
        }

        $useCase = new MatchUseCase();
        $match = $useCase->registerMove(0, $matchInit->id);

        $playedMove = $match->board[0];

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($nextMove, $match->next);
        $this->assertEquals($playedMove, $currentMove);

    }

    /**
     * Test if the usecase service registers when it's O's turn
     */
    public function testRegisterMoveWith0()
    {

        $matchInit = $this->createMatch();
        $matchInit->next = 1;
        $matchInit->save();

        $nextMove = 2;
        $currentMove = 1;

        foreach([0, 1, 2, 3, 4, 5, 6, 7, 8, 9] as $posistion) {
            $this->createMove($posistion, $matchInit->id);
        }

        $useCase = new MatchUseCase();
        $match = $useCase->registerMove(0, $matchInit->id);

        $playedMove = $match->board[0];

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($match->next, $nextMove);
        $this->assertEquals($playedMove, $currentMove);

    }

    /**
     * Test if the usecase service return a specific match with the board
     */
    public function testFind()
    {

        $matchInit = $this->createMatch();
        $this->createMove(0, $matchInit->id);

        $useCase = new MatchUseCase();
        $match = $useCase->find($matchInit->id);

        $this->assertInstanceOf(Match::class, $match);
        $this->assertNotEmpty($match->board);

    }

    /**
     * Test if the usecase service delete a specific match and return the rest
     */
    public function testDelete()
    {
        $matchInit = $this->createMatch();
        $this->createMove(0, $matchInit->id);

        $useCase = new MatchUseCase();
        $matches = $useCase->delete($matchInit->id);

        $matchFound = Match::find($matchInit->id);

        $this->assertInstanceOf(Collection::class, $matches);
        $this->assertEmpty($matchFound);
    }

}