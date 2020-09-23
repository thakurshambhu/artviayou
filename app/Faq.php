<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $fillable = [
        'qus','ans', 'is_deleted', 'is_active'
    ];
}
