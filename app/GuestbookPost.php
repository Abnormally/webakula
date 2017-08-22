<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'content',
    ];
}
