<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @return string
     */
    public function guestbookAll() {
        return GuestbookPost::withTrashed()->get()->toJson();
    }

    /**
     * @return string
     */
    public function guestbookNonDeleted() {
        return GuestbookPost::all()->toJson();
    }

    /**
     * @return string
     */
    public function guestbookDeleted() {
        return GuestbookPost::onlyTrashed()->get()->toJson();
    }

    /**
     * @param int $id
     * @return string
     */
    public function guestbookOne($id) {
        $post = GuestbookPost::withTrashed()
            ->where('id', $id)
            ->get();

        if ($post) {
            return $post->toJson();
        } else {
            return '[{}]';
        }
    }
}
