<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title','des_first','user_id', 'media_url','is_deleted', 'is_active'
    ];

    // Relations with ArtworkImage Model
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
