<?php

namespace App\Http\Controllers;

use Auth;
use App\GuestbookPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'posts_headings' => ['panel-danger', 'panel-default dl-panel-default-fix', 'panel-success'],
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
            if (!Auth::guest()) $post->user_id = Auth::id();
            $post->name = htmlspecialchars($response['name']);
            $post->email = Auth::guest() ? $request['email'] : Auth::user()->email;
            $post->content = htmlspecialchars($request['text']);

            if ($request->has('reaction')) {
                $reaction = (int) $request->get('reaction');
                if ($reaction > -1 && $reaction < 3) $post->reaction = $reaction;
            }

            $post->save();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if(starts_with($file->getMimeType(), 'image')) {
                    $file->storePubliclyAs('public/images/guestbook', $post->id . '.' . $file->getClientOriginalExtension());
                    $post->avatar = 'img/guestbook/' . $post->id . '.' . $file->getClientOriginalExtension();

                    $post->update();
                }
            } elseif (!Auth::guest() && Auth::user()->avatar) {
                $post->avatar = Auth::user()->avatar;
                $post->update();
            }
        }

        $response['reaction'] = $request->get('reaction');

        return json_encode($response);
    }
}
