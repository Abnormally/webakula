<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Show the GuestBook page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guestbook() {
        return view('guestbook.guestbook', [
            'posts' => GuestbookPost::getPagination(),
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|string|email|max:100',
                'text' => 'required|string|min:10',
            ]);

            $response = [
                'name' => $request['name'],
                'has_errors' => $validator->errors()->any(),
                'errors' => $validator->errors()
            ];
        } else {
            $validator = Validator::make($request->all(), [
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
            $post->avatar = 'img/guestbook/0.jpg';
            $post->content = $request['text'];

            $post->save();

            if (Input::hasFile('file')) {
                $file = Input::file('file');
                $file->move('img/guestbook', $post->id . '.' . $file->getClientOriginalExtension());
                $post->avatar = 'img/guestbook/' . $post->id . '.' . $file->getClientOriginalExtension();

                $post->update();
            }
        }

        return json_encode($response);
    }
}
