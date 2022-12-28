<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BlogRepositoryInterface;
use App\Mail\SubscribersMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class AdminBlogController extends Controller
{
    use HttpResponses;

    private BlogRepositoryInterface $BlogRepository;

    public function __construct(BlogRepositoryInterface $BlogRepository)
    {
        $this->BlogRepository = $BlogRepository;
    } 

    public function index () {
        return view('admin.blogs.blogs', [
            'blogs' => Blog::where('visible', true)->latest()->paginate(10)
        ]);
    }

    public function addBlog () {
        return view('admin.blogs.add', [
            'categories' => Category::where('visible', true)->get()
        ]);
    }

    public function blogEntry (Request $request) {

        return $this->BlogRepository->createBlog($request);

        // $validator = Validator::make($request->all(), [
        //     'title' => ['required'],
        //     'body' => ['required'],
        //     'category_id' => ['required', Rule::exists('categories', 'id')],
        //     'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20480'] //  'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        // ]);

        // if ( $validator->fails() ) {
        //     return $this->error(null, $validator->errors()->first(), 422);

        // }

        // try{
        //     $blog = new Blog();
        //     $blog->title = $request->input('title');
        //     $blog->body = $request->input('body');
        //     $blog->category_id = $request->input('category_id');
        //     $blog->user_id = auth()->id();
        //     $blog->reg_id = auth()->id();
        //     $blog->token = str_shuffle(md5(date("ymdhis")));

        //     if ($request->hasFile('thumbnail')) {
        //         $file = $request->file('thumbnail');
        //         $extension = $file->getClientOriginalExtension();
        //         $filename = time() . '.' . $extension;
        //         $file->move('uploads/', $filename);
        //         $blog->thumbnail = $filename;
        //     }
        //     if($blog->save()) {
        //         $subscribers = Subscriber::where('visible', true)->get();
        //         foreach ($subscribers as $subscriber) { 
        //             Mail::to($subscriber->email)->queue(new SubscribersMail($blog, $subscriber));
        //         }
        //     }
        //     return $this->success(new BlogResource($blog), 'Blog created successfully!', 201);
        // }catch (\Throwable $th){
        //     return $this->error(null, 'Server Error!', 500);
        // }

    }

    public function viewBlog ($token) {
        $blog = Blog::where('token', $token)->first();
        if (!$blog) {
            abort(403);
        }
        return view('admin.blogs.view', [
            'blog' => $blog,
        ]);
    }

    public function editBlog ($token) {
        $blog = Blog::where('token', $token)->first();
        if (!$blog) {
            abort(403);
        }
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'categories' => Category::where('visible', true)->get()
        ]);
    }

    public function updateBlog (Request $request, $token) {
        $blog = Blog::where('token', $token)->first();
        if (!$blog) {
            return $this->error(null, 'Blog not found!', 403);
        }
        $id = $blog->id;
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20480'] //  'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ( $validator->fails() ) {
            return $this->error(null, $validator->errors()->first(), 422);

        }

        try{
            $blog = Blog::where('id', $id)->first();
            if (!$blog){
                return $this->error(null, 'Blog not found!', 403);
            }
            $blog->title = $request->input('title');
            $blog->body = $request->input('body');
            $blog->category_id = $request->input('category_id');
            $blog->upd_id = auth()->id();

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/', $filename);
                $blog->thumbnail = $filename;
            }
            $blog->update();
            return $this->success(new BlogResource($blog), 'Blog updated successfully!', 201);
        }catch (\Throwable $th){
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function deleteBlog (Request $request) {
        try {
            $blog = Blog::find($request->blog_id);
            $blog->visible = false;
            $blog->save();
            return $this->success(null, 'Blog deleted successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }
}
