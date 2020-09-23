<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'artwork_id', 'artist_payment', 'artist_payment_status', 'admin_commission', 'artist_id', 'payment_id', 'delivery_address', 'status', 'paypal_response', 'artwork_info', 'shipping_status', 'tracking_number', 'carrier'
    ];

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function artist()
    {
        return $this->belongsTo('App\User','artist_id','id');
    }

    public function shipping_address()
    {
        return $this->hasOne('App\ShippingAddress','order_id','id');
    }
}
