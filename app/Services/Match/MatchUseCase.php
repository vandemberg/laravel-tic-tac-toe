<?php
namespace App\Services\Match;

use App\Repositories\MatchRepository;
use App\Repositories\MoveRepository;
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

    public function list()
    {
        $matchRepository = new MatchRepository();
        $matches = $matchRepository->all();

        $matches->each(function($match) {
            $match->board = $match->moves->pluck('value');
        });

        return $matches;
    }

    public function find($id)
    {
        $matchRepository = new MatchRepository();
        $match = $matchRepository->findById($id);
        $match->board = $match->moves->pluck('value');
        return $match;
    }

    public function delete($id)
    {
        $repository = new MatchRepository();
        $repository->delete($id);

        $list = $repository->all();

        return $list;

    }

    public function registerMove($position, $id)
    {
        $repositoryMatch = new MatchRepository();
        $repositoryMove = new MoveRepository();

        $match = $repositoryMatch->findById($id);
        $matchId = $match->id;

        // Register the move
        $value = $match->next;
        $repositoryMove->changeByPosition($matchId, $position, $value);

        // Check if someone win
        $winner = new Winner();

        if($winner->check($match, $position, $value)) {
            $match->winner = $value;
            $match->save();
        }

        // change the next player
        if ( $match->next == 1) {
            $match->next = 2;
        } else {
            $match->next = 1;
        }

        $match->save();

        $match->board = $match->moves->pluck('value');

        return $match;

    }

}