<?php

namespace App\Repositories;


use App\Http\Resources\BlogResource;
use App\Interfaces\BlogRepositoryInterface;
use App\Mail\SubscribersMail;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Subscriber;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BlogRepository implements BlogRepositoryInterface
{
    use HttpResponses;

    public function getAllBlogs($count = 6)
    {
            $blogs = Blog::where('visible', true)
                ->where('status', true)
                ->latest()
                ->paginate($count);
            return $blogs;
    }

    public function getBlogById($blogId)
    {
        $blog = Blog::where('visible', true)
            ->where('status', true)
            ->findOrFail($blogId);
        return $blog;
    }

    public function searchBlog($search)
    {
        $blogs = Blog::where('visible', true)
            ->where('title','LIKE', '%'.$search.'%')
            ->orWhere('body', 'LIKE', '%'.$search.'%')
            ->get();
        return $blogs;
    }

    public function getBlogsByCategory ($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $blogs = $category->blogs->where('visible', true);
        return $blogs;
    }


    // ---------------------------

    public function deleteBlog($blogId)
    {
        try {
            $blog = Blog::find($blogId);
            if ( !$blog ) {
                return $this->error(null, 'Blog not found!', 403);
            }
            $blog->visible = false;
            $blog->save();
            return $this->success(null, 'Blog deleted successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function createBlog($request)
    {
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
            $blog = new Blog();
            $blog->title = $request->input('title');
            $blog->body = $request->input('body');
            $blog->category_id = $request->input('category_id');
            $blog->user_id = auth()->id();
            $blog->reg_id = auth()->id();
            $blog->token = str_shuffle(md5(date("ymdhis")));

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/', $filename);
                $blog->thumbnail = $filename;
            }
            if($blog->save()) {
                $subscribers = Subscriber::where('visible', true)->get();
                foreach ($subscribers as $subscriber) { 
                    Mail::to($subscriber->email)->queue(new SubscribersMail($blog, $subscriber));
                }
            }
            return $this->success(new BlogResource($blog), 'Blog created successfully!', 201);
        }catch (\Throwable $th){
            return $this->error(null, 'Server Error!', 500);
        }

    }

    public function updateBlog($request, $blogId)
    {
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
            $blog = Blog::where('id', $blogId)->first();
            if (!$blog){
                return $this->error(null, 'Blog not found!', 403);
            }
            $blog->title = $request->input('title');
            $blog->body = $request->input('body');
            $blog->category_id = $request->input('category_id');
            $blog->upd_id = 3;

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

}
