<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
     protected $fillable = [
        'email', 'commission_persentage','is_deleted', 'is_active'
    ];
}
