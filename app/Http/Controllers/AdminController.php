<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use Auth;
use Illuminate\Http\Request;
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
     * Show admins (role 4, 5) ands moderators (role 3) index page.
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unpublishedPage() {
        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getUnpublished(),
            'status' => 0
        ]);
    }

    /**
     * Show published posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publishedPage() {
        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getPublished(),
            'status' => 2
        ]);
    }

    /**
     * Show hidden posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenPage() {
        if (Auth::user()->role < 3) $this->createNotFound();
        return view('admin.posts', [
            'posts' => GuestbookPost::getHiddenPosts(),
            'status' => 3
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
