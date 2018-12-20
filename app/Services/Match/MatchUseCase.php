<?php
namespace App\Services\Match;

use App\Repositories\MatchRepository;
use App\Repositories\MoveRepository;
use App\Services\TicTacToe\NextMove;
use App\Services\TicTacToe\Winner;
use Illuminate\Database\Eloquent\Collection;

class MatchUseCase
{

    /**
     * Create a new Match and concat to end of the collection
     *
     * @return Collection
     */
    public function addNewMatch() : Collection
    {
        // Get list of all matches
        $matchRepository = new MatchRepository();
        $matches = $matchRepository->all();

        // Use the count, sum one and create a new name
        $countMatches = $matches->count();
        $nameMatch = 'Match ' . ($countMatches  + 1);

        $match = $matchRepository->create([
            'name'   => $nameMatch,
            'winner' => 0, // default value
            'next'   => 1 //  default value
        ]);

        // Prepare the board game creating eight positions
        $positions = [0, 1, 2, 3, 4, 5, 6, 7, 8];
        $moveRepository = new MoveRepository();

        foreach($positions as $position) {
            $moveRepository->create([
                'position' => $position,
                'value'     => 0,
                'match_id'  => $match->id
            ]);
        }

        // Add the match to end of Collection
        $matches->push($match);

        return $matches;

    }

    /**
     * Return all matches
     *
     * @return Collection
     */
    public function list()
    {
        $matchRepository = new MatchRepository();
        $matches = $matchRepository->all();

        $matches->each(function($match) {
            $match->board = $match->moves->pluck('value');
        });

        return $matches;
    }

    /**
     * Return a match by the ID with the board
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        $matchRepository = new MatchRepository();
        $match = $matchRepository->findById($id);
        $match->board = $match->moves->pluck('value');
        return $match;
    }

    /**
     * Delete the match and return the rest
     *
     * @param $id
     * @return Collection
     */
    public function delete($id)
    {
        $repository = new MatchRepository();
        $repository->delete($id);

        $list = $repository->all();

        return $list;

    }

    /**
     * Register the move and check if the played move win
     *
     * @param $position
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function registerMove($position, $id)
    {
        $repositoryMatch = new MatchRepository();
        $repositoryMove = new MoveRepository();

        // Find the Match
        $match = $repositoryMatch->findById($id);
        $matchId = $match->id;

        // Register the move
        $playedMove = $match->next;
        $repositoryMove->changeByPosition($matchId, $position, $playedMove);

        // Check if someone win
        $winner = new Winner();
        $match = $winner->verify($match, $position, $playedMove);

        // change the next move
        $nextMove = new NextMove();
        $match = $nextMove->change($match);

        $match->board = $match->moves->pluck('value');

        return $match;

    }

}