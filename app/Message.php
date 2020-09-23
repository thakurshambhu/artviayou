<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from_user_id','to_user_id','type','file_format','file_path','message','date','time','read_status','ip',
    ];

    public function sender()
    {
        return $this->belongsTo('App\User','from_user_id','id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User','to_user_id','id');
    }
}

