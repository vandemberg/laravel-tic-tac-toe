<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function all($columns = ['*']) : Collection;

    public function create(Array $data);

    public function update(Array $data, int $id);

    public function findById(int $id);

    public function delete(int $id);

}