<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id','media_url', 'name', 'is_deleted', 'is_active'
    ];

    // Relations with SubCategory Model
    public function category()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }
}
