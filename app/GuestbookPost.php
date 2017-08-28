<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    const perPage = 6;
    const perPageAdmin = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'content', 'user_id',
    ];

    /**
     * @param int $page
     * @param null|int $perPage
     * @param int $status
     * @param bool $ucFlag
     * @return mixed
     */
    public static function getLatestPerPage($page = 1, $perPage = null, $status = 2, $ucFlag = true) {
        $perPage = $perPage ? $perPage : self::perPage;
        $start = ($page - 1) * $perPage;

        return self::where('status', $status)
            ->orderBy($ucFlag ? 'updated_at' : 'created_at', 'desc')
            ->limit($perPage)
            ->offset($start)
            ->get();
    }

    /**
     * Get amount of published posts.
     *
     * @param int $status
     * @return \Illuminate\Support\Collection
     */
    public static function getAmountOf($status = 2) {
        return DB::table('guestbook_posts')
            ->select('status', DB::raw('count(*) as total'))
            ->where('status', '=', $status)
            ->groupBy('status')
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

    public static function getById($id) {
        $id = (int) $id;

        return self::where('id', $id)
            ->get();
    }
}
