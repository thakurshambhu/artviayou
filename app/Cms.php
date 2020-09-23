<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
     protected $fillable = [
        'title','slug','des_first','first_img_url','des_second','second_img_url', 'is_deleted', 'is_active'
    ];
}
