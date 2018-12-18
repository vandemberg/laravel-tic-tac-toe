<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchController extends Controller
{

    /**
     * List all Matches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->fakeMatches(), 200);
    }

    /**
     * Find a specific Match
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'id' => $id,
            'name' => 'Match'.$id,
            'next' => 2,
            'winner' => 0,
            'board' => [
                1, 0, 2,
                0, 1, 2,
                0, 0, 0,
            ],
        ]);
    }

    /**
     * Register the move changing the 0 value to 1 or 2
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $board = [
            1, 0, 2,
            0, 1, 2,
            0, 0, 0,
        ];

        $position = $request->get("position");
        $board[$position] = 2;

        return response()->json([
            'id' => $id,
            'name' => 'Match'.$id,
            'next' => 1,
            'winner' => 0,
            'board' => $board,
        ]);
    }

    /**
     * Destroy the match with the board related
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return response()->json($this->fakeMatches()->filter(function($match) use($id){
            return $match['id'] != $id;
        })->values());
    }

    /**
     * Creates a fake array of matches
     *
     * @return \Illuminate\Support\Collection
     */
    private function fakeMatches()
    {
        return collect([
            [
                'id' => 1,
                'name' => 'Match1',
                'next' => 2,
                'winner' => 1,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 2, 1,
                ],
            ],
            [
                'id' => 2,
                'name' => 'Match2',
                'next' => 1,
                'winner' => 0,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 0, 0,
                ],
            ],
            [
                'id' => 3,
                'name' => 'Match3',
                'next' => 1,
                'winner' => 0,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 2, 0,
                ],
            ],
            [
                'id' => 4,
                'name' => 'Match4',
                'next' => 2,
                'winner' => 0,
                'board' => [
                    0, 0, 0,
                    0, 0, 0,
                    0, 0, 0,
                ],
            ],
        ]);
    }

}