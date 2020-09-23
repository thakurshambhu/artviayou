<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category', 'sub_category', 'style', 'subject', 'user_id', 'top', 'trending', 'is_deleted', 'is_publised',
    ];

    // Relations with Category Model
    public function style_detail()
    {
        return $this->belongsTo('App\Style','style','id');
    }
    // Relations with Category Model
    public function subject_detail()
    {
        return $this->belongsTo('App\Subject','subject','id');
    }
    // Relations with Category Model
    public function category_detail()
    {
        return $this->belongsTo('App\Category','category','id');
    }
    // Relations with SubCategory Model
    public function sub_category_detail()
    {
        return $this->belongsTo('App\SubCategory','sub_category','id');
    }
    // Relations with User Model
    public function artist()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    // Relations with ArtworkImage Model
    public function artwork_images()
    {
        return $this->hasMany('App\ArtworkImage','artwork_id','id');
    }
    // Relations with Variant Model
    public function variants()
    {
        return $this->hasMany('App\Variant','artwork_id','id');
    } 
    // Relations with Variant Model
    public function artwork_like()
    {
        return $this->hasMany('App\SavedArtwork','artwork_id','id')->where('status', 'like');
    }
    
    public function saved_artist()
    {
        return $this->belongsTo('App\SavedArtist','user_id','id');
    }
}
