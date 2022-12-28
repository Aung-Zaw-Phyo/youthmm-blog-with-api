<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryRepository implements CategoryRepositoryInterface
{
    use HttpResponses;

    public function getAllCategories() {
        $categories = Category::where('visible', true)->latest()->paginate(10);
        return $categories;
    }

    public function createCategory($request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('categories', 'name')]
        ]);

        if ( $validator->fails() ) {
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try{
            $category = new Category();
            $category->name = $request->name;
            $category->user_id = auth()->id();
            $category->reg_id = auth()->id();
            $category->token = str_shuffle(md5(date("ymdhis")));
            $category->save();
            return $this->success($category, 'Category created successfully!', 201);
        }catch (\Throwable $th){
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function updateCategory($request, $categoryId) { 
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('categories', 'name')->ignore($categoryId)]
        ]);
        if ( $validator->fails() ) {
            return $this->error(null, $validator->messages()->first(), 422);
        }
        try {
            $category = Category::find($categoryId);
            if ( !$category ) {
                return $this->error(null, 'Category not found!', 403);
            }
            $category->name = $request->name;
            $category->upd_id = auth()->id();
            $category->update();
            return $this->success($category, 'Category updated successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function deleteCategory($categoryId) {
        try {
            $category = Category::find($categoryId);
            if ( !$category ) {
                return $this->error(null, 'Category not found!', 403);
            }
            $blogs = $category->blogs;
            foreach($blogs as $blog) {
                $blog->visible = false;
                $blog->update();
            }
            $category->visible = false;
            $category->update();
            return $this->success(null, 'Category deleted successfully!', 200);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }
    
}
