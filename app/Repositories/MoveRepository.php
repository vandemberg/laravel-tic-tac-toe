<?php
namespace App\Repositories;

use App\Models\Move;

class MoveRepository extends AbstractRepository
{

    public function model()
    {
        return Move::class;
    }

}