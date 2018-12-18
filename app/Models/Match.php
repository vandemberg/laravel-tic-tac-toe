<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';
    protected $fillable = ['name', 'next', 'winner'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function moves() : Collection
    {
        return $this->belongsToMany(Move::class);
    }

}
