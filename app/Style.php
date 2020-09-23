<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_deleted', 'is_active'
    ];
}
