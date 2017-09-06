<?php

namespace App\Http\Controllers;

use App\GuestbookPost;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show admins (role 4, 5) and moderators (role 3) index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.index');
    }

    /**
     * Returns amounts of posts with different status field.
     *
     * @return string
     */
    public function getBadges() {
        return json_encode(GuestbookPost::getBadges());
    }

    /**
     * Show unpublished posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unpublishedPage() {
        return view('admin.posts', [
            'posts' => GuestbookPost::getPagination(0, 1),
        ]);
    }

    /**
     * Show published posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publishedPage() {
        return view('admin.posts', [
            'posts' => GuestbookPost::getPagination(2, 1),
        ]);
    }

    /**
     * Show hidden posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenPage() {
        return view('admin.posts', [
            'posts' => GuestbookPost::getPagination(3, 1),
        ]);
    }

    /**
     * 'Deleting' the post.
     *
     * @param int $id
     * @return bool
     */
    public function removePost($id) {
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->delete();

        return 'true';
    }

    /**
     * Make post hidden.
     *
     * @param int $id
     * @return bool
     */
    public function hidePost($id) {
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->status = 3;
        $post->update();

        return 'true';
    }

    /**
     * Publish the post.
     *
     * @param int $id
     * @return bool
     */
    public function publishPost($id) {
        $post = GuestbookPost::find($id);
        if (!$post) return 'false';

        $post->status = 2;
        $post->update();

        return 'true';
    }
}
