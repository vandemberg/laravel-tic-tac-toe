<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\Match\MatchUseCase;
use Illuminate\Http\Request;

class MatchController extends Controller
{

    public function store(MatchUseCase $useCase)
    {

        $matches = $useCase->addNewMatch();

        return response()->json($matches, 201);
    }

    /**
     * List all Matches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MatchUseCase $useCase)
    {
        $matches = $useCase->list();
        return response()->json($matches, 200);
    }

    /**
     * Find a specific Match
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MatchUseCase $useCase, $id)
    {
        $match = $useCase->find($id);
        return response()->json($match,200);
    }

    /**
     * Register the move changing the 0 value to 1 or 2
     *
     * @param MatchUseCase $useCase
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MatchUseCase $useCase, Request $request, $id)
    {

        $position = $request->get('position');

        $match = $useCase->registerMove($position, $id);

        return response()->json($match, 201);
    }

    /**
     * Destroy the match with the board related
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MatchUseCase $usecase, $id)
    {
        $restOfMatches = $usecase->delete($id);
        return response()->json($restOfMatches, 200);
    }

}