<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GuestbookPost;
use Session;

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

    /**
     * Show the GuestBook page.
     *
     * @param int|null $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guestbook($page = null) {
        $amount = GuestbookPost::getAmountOfPublished()->first()->total;
        $perPage = Session::has('perPage') ? Session::get('perPage') : GuestbookPost::perPage;
        $pages = ceil($amount / $perPage);
        $page = $page > 0 ? $page : 1;

        return view('guestbook.guestbook', [
            'posts' => GuestbookPost::getLatestPerPage($page, $perPage),
            'pages' => $pages,
            'page' => $page
        ]);
    }

    /**
     * Validate and insert new post.
     *
     * @param Request $request
     * @return string
     */
    public function addPost(Request $request) {
        if (Auth::guest()) {
            $form = [
                'name' => $request['name'],
                'email' => $request['email'],
                'text' => $request['text']
            ];

            $validator = Validator::make($form, [
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|string|email|max:100',
                'text' => 'required|string|min:10',
            ]);

            $response = [
                'name' => $form['name'],
                'has_errors' => $validator->errors()->any(),
                'errors' => $validator->errors()
            ];
        } else {
            $form = [
                'text' => $request['text']
            ];

            $validator = Validator::make($form, [
                'text' => 'required|string|min:10'
            ]);

            $response = [
                'name' => Auth::user()->name,
                'has_errors' => $validator->errors()->any(),
                'errors' => $validator->errors()
            ];
        }

        if (!$validator->errors()->any()) {
            $post = new GuestbookPost;
            $post->user_id = Auth::guest() ? 0 : Auth::id();
            $post->name = $response['name'];
            $post->email = Auth::guest() ? $request['email'] : Auth::user()->email;
            $post->content = $request['text'];

            $post->save();
        }

        return json_encode($response);
    }
}
