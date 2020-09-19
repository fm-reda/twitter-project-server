<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    protected $table = 'twitters';
    protected $fillable = ['twitterID', 'name', 'text', 'avatar'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
