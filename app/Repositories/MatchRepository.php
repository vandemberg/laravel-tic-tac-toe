<?php
namespace App\Repositories;

use App\Models\Match;

class MatchRepository extends AbstractRepository
{

    public function model()
    {
        return Match::class;
    }

}