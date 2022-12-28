<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Interfaces\BlogRepositoryInterface;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    use HttpResponses;

    private BlogRepositoryInterface $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAllBlogs()
    {
        try {
            $blogs = $this->blogRepository->getAllBlogs();
            return $this->success(BlogResource::collection($blogs), 'get all blogs', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Internal Server Error!', 500);
        }
    }

   public function searchBlog ($search) {
       try {
           $blogs = $this->blogRepository->searchBlog($search);
           return $this->success(BlogResource::collection($blogs), 'get search blogs', 201);
       }catch (\Throwable $th) {
           return $this->error(null, 'Server error!', 500);
       }
   }

    public function getBlogById($id)
    {
        try {
            $blog = $this->blogRepository->getBlogById($id);
            return $this->success(new BlogResource($blog), 'get blog', 201);
        } catch (\Throwable $th) {
            return $this->error(null, 'Forbidden', 403);
        }
    }

    public function getBlogsByCategory ($categoryId) {
        try {
            $blogs = $this->blogRepository->getBlogsByCategory($categoryId);
            return $this->success(BlogResource::collection($blogs), 'get blogs', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Forbidden', 403);
        }
    }

    public function getAuthor ($id) {
        try {
            $author = User::findOrFail($id);
            return $this->success(new UserResource($author), 'get author', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Forbidden', 403);
        }
    }

    public function getCategory ($id) {
        try {
            $category = Category::findOrFail($id);
            return $this->success(new CategoryResource($category), 'get category', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Forbidden', 403);
        }
    }

    public function getComments ($blogId) {
        try {
            $blog = Blog::findOrFail($blogId);
            $comments = $blog->comments;
            return $this->success(CommentResource::collection($comments), 'get comments', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Forbidden', 403);
        }
    }


    //  -----------------------------

    public function createBlog(Request $request)
    {

        return $this->blogRepository->createBlog($request);
    }

    public function updateBlog (Request $request, $id) {
        return $this->blogRepository->updateBlog($request, $id);
    }

    public function deleteBlog ($id) {
        try {
            $this->blogRepository->deleteBlog($id);
            return $this->success(null, 'Blog deleted successfully!', 201);
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function latest () {
        $blogs = Blog::latest()->take(3)->get();
        return $this->success(BlogResource::collection($blogs), 'Get latest blogs', 200);
    }

    public function random () {
        $blogs = Blog::all()->random(3);
        return $this->success(BlogResource::collection($blogs), 'Get random blogs', 200);
    }

    public function categories () {
        $categories = Category::all();
        return $this->success(CategoryResource::collection($categories), 'Get all categories', 200);
    }

}
