<?php

namespace App;

use DB;
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
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getBadges() {
        return DB::table('guestbook_posts')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
    }

    public static function getUnpublished() {
        return self::where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getPublished() {
        return self::where('status', 2)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getHiddenPosts() {
        return self::where('status', 3)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
