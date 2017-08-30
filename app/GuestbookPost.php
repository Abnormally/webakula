<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    protected static $perPageGuest;
    protected static $perPageAdmin;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $options = json_decode(file_get_contents('../config/options.json'));

        if ($options) {
            self::$perPageGuest = $options->pagination->perPageGuest;
            self::$perPageAdmin = $options->pagination->perPageAdmin;
        } else {
            self::$perPageGuest = 6;
            self::$perPageAdmin = 4;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'content', 'user_id',
    ];

    /**
     * Returns pagination by status and type.
     *
     * @param int $status
     * @param int $type
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPagination($status = 2, $type = 0) {
        return self::where('status', '=', $status)
            ->orderBy('updated_at', 'desc')
            ->paginate($type ? self::$perPageAdmin : self::$perPageGuest);
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
