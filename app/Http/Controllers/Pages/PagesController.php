<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home () {
        return view('pages.home', [
            'blogs' => Blog::where('visible', true)->latest()->take(3)->get()
        ]);
    }

    public function posts () {
        return view('pages.posts', [
            'blogs' => Blog::where('visible', true)->latest()
                                ->filter(request(['search','category']))
                                ->paginate(6)
                                ->withQueryString(),
            'categories' => Category::where('visible', true)->get()
        ]);
    }

    public function viewPost ($token) {
        $blog = Blog::where('token', $token)->first();
        if (!$blog){
            abort(403);
        }
        return view('pages.view', [
            'blog' => $blog
        ]);
    }

    public function comment (Request $request, $token) {
        $formData = $request->validate([
            'body' => ['required']
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->blog_id = Blog::where('token', $token)->first()->id;
        $comment->user_id = auth()->id();
        $comment->reg_id = auth()->id();
        $comment->token = str_shuffle(md5(date("ymdhis")));
        $comment->save();
        return redirect()->route('page_viewPost', $token);
    }

    public function login () {
        return view('pages.login');
    }

    public function register () {
        return view('pages.register');
    }

    public function profile () {
        return view('pages.profile');
    }

}
