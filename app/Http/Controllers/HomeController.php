<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuestbookPost;

class HomeController extends Controller
{
    /**
     * Show the application index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function guestbook() {
        return view('guestbook.guestbook', [
            'posts' => GuestbookPost::getLatest(),
        ]);
    }
}
