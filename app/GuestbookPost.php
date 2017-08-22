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
        'name', 'email', 'content', 'user_id',
    ];

    public static function getLatest() {
        return self::where('status', 2)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }
}
