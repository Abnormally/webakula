<?php

namespace App;

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
     * Get amount of {status} posts.
     *
     * @param int $status
     * @return \Illuminate\Support\Collection
     */
    public static function getAmountOf($status = 2) {
        return self::selectRaw('`status`, count(*) as total')
            ->where('status', '=', $status)
            ->groupBy('status')
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getBadges() {
        return self::selectRaw('`status`, count(*) as total')
            ->groupBy('status')
            ->get();
    }
}
