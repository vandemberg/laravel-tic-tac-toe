<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements InterfaceRepository
{

    protected $model;

    /**
     * When init the repository the model is started
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $this->model = $this->model();
    }

    /**
     * method to set the Eloquent Model ORM
     * @return mixed
     */
    abstract function model() : Model;

    public function all($columns = ['*']) : Collection
    {
        return $this
                ->model
                ->select(...$columns)
                ->with('moves')
                ->get();
    }

    /**
     * Method to find the row with a ID
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this
                ->model
                ->where("id", $id)
                ->with('moves')
                ->first();
    }

    /**
     * Method to create a object and insert in the database
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Method to update a specific row
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $obj = $this
                ->model
                ->where("id", $id)
                ->first();

        $obj->fillable($data);
        $obj->save();

        return $obj;

    }

    /**
     * destroy a row
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $obj = $this
                ->model
                ->where("id", $id)
                ->first();

        $obj->delete();
    }

}