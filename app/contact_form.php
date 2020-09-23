<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact_form extends Model
{
     protected $fillable = [
        'name','mobile_number', 'email', 'message'
    ];
}
