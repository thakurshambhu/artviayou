<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artwork_id', 'variant_type', 'editions_count', 'width', 'height', 'price', 'worldwide_shipping_charge', 'not_for_sale', 'is_deleted', 'is_active',
    ];

    // Relations with Artwork Model
    public function artwork()
    {
        return $this->belongsTo('App\Artwork','artwork_id','id');
    }
}
