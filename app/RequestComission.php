<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestComission extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'artist_id', 'request_status'
    ];

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function artist()
    {
        return $this->belongsTo('App\User','artist_id','id');
    }
}
