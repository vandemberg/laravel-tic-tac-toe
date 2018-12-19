<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IRepository
{

    protected $model;

    /**
     * When init the repository the model is started. The Class get by the model function gonna be instantiated
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $class = $this->model();
        $this->model = new $class;
    }

    /**
     * method to set the Eloquent Model ORM
     * @return mixed
     */
    abstract function model();

    public function all($columns = ['*']) : Collection
    {
        return $this
                ->model
                ->select($columns)
                ->get();
    }

    /**
     * Method to find the row with a ID
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id)
    {
        return $this
                ->model
                ->where("id", $id)
                ->first();
    }

    /**
     * Method to create a object and insert in the database
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $obj = $this->model->fill($data);
        return $obj;
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

        $obj->fill($data);
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