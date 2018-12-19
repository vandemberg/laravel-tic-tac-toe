<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Move extends Model
{

    use SoftDeletes;

    protected $table = 'moves';
    protected $fillable = ['position', 'value', 'match_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function match()
    {
        return $this->belongsTo(Match::class);
    }

}
