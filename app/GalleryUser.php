<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'alias', 'biography', 'address', 'postal_code', 'city', 'state', 'country','media_url', 'is_deleted', 'is_active', 'is_featured', 'email_verified_at', 'user_type'
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
    
}
