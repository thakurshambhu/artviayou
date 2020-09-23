<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','role','is_deleted','is_active', 'user_name', 'email', 'paypal_email', 'password','alias', 'biography', 'address', 'postal_code', 'city', 'state', 'name', 'country','media_url','is_featured','provider', 'provider_id', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relations with ArtworkImage Model
    public function artworks()
    {
        return $this->hasMany('App\Artwork','user_id','id')->orderBy('id', 'desc');
    }
}
