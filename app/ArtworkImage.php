<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtworkImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artwork_id', 'media_url', 'is_deleted', 'is_active',
    ];

    // Relations with Artwork Model
    public function artwork()
    {
        return $this->belongsTo('App\Artwork','artwork_id','id');
    }
}
