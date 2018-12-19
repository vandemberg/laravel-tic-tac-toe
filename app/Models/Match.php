<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Match extends Model
{

    use SoftDeletes;

    protected $table = 'matches';
    protected $fillable = ['name', 'next', 'winner'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function moves()
    {
        return $this->hasMany(Move::class);
    }

}