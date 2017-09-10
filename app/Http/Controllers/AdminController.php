<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return array
     */
    public function importPosts(Request $request) {
        $file = $request->file('posts');
        $response = [];

        if ($file && $file->getMimeType() == "text/plain") {
            $posts = json_decode(file_get_contents($file));

            foreach ($posts as &$post) {
                $temp_post = null;

                if (isset($post->id) && $post->id !== null) {
                    $temp_post = GuestbookPost::find($post->id);
                }

                if ($temp_post) {
                    foreach ($temp_post->getFillable() as &$field) {
                        $temp_post->$field = $post->$field;
                    }

                    $temp_post->update();
                } else {
                    $temp_post = new GuestbookPost();

                    foreach ($temp_post->getFillable() as &$field) {
                        $temp_post->$field = $post->$field;
                    }

                    $temp_post->save();
                }
            }

            $response['errors'] = false;
        } elseif ($file) {
            $response['errors'] = true;
            $response['answer'] = 'Этот файл неприемлем';
        } else {
            $response['errors'] = true;
            $response['answer'] = 'Файл отсутствует';
        }

        return $response;
    }
}
