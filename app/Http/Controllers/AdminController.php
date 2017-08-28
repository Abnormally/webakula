<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use Auth;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Helper function.
     *
     * @param null $message
     * @throws NotFoundHttpException
     */
    private function createNotFound($message = null) {
        throw new NotFoundHttpException($message);
    }

    /**
     * Show admins (role 4, 5) and moderators (role 3) index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.index');
    }

    /**
     * Returns amounts of posts with different status field.
     *
     * @return string
     */
    public function getBadges() {
        if (Auth::user()->role < 3) $this->createNotFound();
        return json_encode(GuestbookPost::getBadges());
    }

    /**
     * Show unpublished posts.
     *
     * @param null|int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unpublishedPage($page = null) {
        $amount = GuestbookPost::getAmountOf(0)->first()->total;
        $perPage = Session::has('perPageAdmin') ? Session::get('perPageAdmin') : GuestbookPost::perPageAdmin;
        $pages = ceil($amount / $perPage);
        $page = $page > 0 ? $page : 1;

        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getLatestPerPage($page, $perPage, 0, false),
            'link' => 'admin.unpublished.page',
            'pages' => $pages,
            'page' => $page,
        ]);
    }

    /**
     * Show published posts.
     *
     * @param null|int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publishedPage($page = null) {
        $amount = GuestbookPost::getAmountOf()->first()->total;
        $perPage = Session::has('perPageAdmin') ? Session::get('perPageAdmin') : GuestbookPost::perPageAdmin;
        $pages = ceil($amount / $perPage);
        $page = $page > 0 ? $page : 1;

        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getLatestPerPage($page, $perPage, 2, false),
            'link' => 'admin.published.page',
            'pages' => $pages,
            'page' => $page,
        ]);
    }

    /**
     * Show hidden posts.
     *
     * @param null|int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenPage($page = null) {
        $amount = GuestbookPost::getAmountOf(3)->first()->total;
        $perPage = Session::has('perPageAdmin') ? Session::get('perPageAdmin') : GuestbookPost::perPageAdmin;
        $pages = ceil($amount / $perPage);
        $page = $page > 0 ? $page : 1;

        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getLatestPerPage($page, $perPage, 3, false),
            'link' => 'admin.hidden.page',
            'pages' => $pages,
            'page' => $page,
        ]);
    }

    /**
     * 'Deleting' the post.
     *
     * @param int $id
     * @return bool
     */
    public function removePost($id) {
        if (Auth::user()->role < 3) $this->createNotFound();
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->status = null;
        $post->save();

        return 'true';
    }

    /**
     * Make post hidden.
     *
     * @param int $id
     * @return bool
     */
    public function hidePost($id) {
        if (Auth::user()->role < 3) $this->createNotFound();
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->status = 3;
        $post->save();

        return 'true';
    }

    /**
     * Publish the post.
     *
     * @param int $id
     * @return bool
     */
    public function publishPost($id) {
        if (Auth::user()->role < 3) $this->createNotFound();
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->status = 2;
        $post->save();

        return 'true';
    }
}
