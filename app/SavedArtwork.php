<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedArtwork extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'artwork_id', 'status', 'guest_id'
    ];

    // Relations with Category Model
    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    // Relations with Category Model
    public function saved_artwork()
    {
        return $this->belongsTo('App\Artwork','artwork_id','id');
    }
}
