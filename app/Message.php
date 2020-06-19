<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $quarder = [];

    protected $fillable = ['from', 'to', 'text'];
}
