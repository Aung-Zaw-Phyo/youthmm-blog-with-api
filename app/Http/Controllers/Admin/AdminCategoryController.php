<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    use HttpResponses;

    private CategoryRepositoryInterface $CategoryRepository;

    public function __construct(CategoryRepositoryInterface $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }   


    public function categories () {
        return view('admin.categories.categories', [
            'categories' => $this->CategoryRepository->getAllCategories()
        ]);
    }

    public function addCategory () {
        return view('admin.categories.add');
    }

    public function categoryEntry (Request $request) {

        return $this->CategoryRepository->createCategory($request);

        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', Rule::unique('categories', 'name')]
        // ]);

        // if ( $validator->fails() ) {
        //     return $this->error(null, $validator->messages()->first(), 422);
        // }

        // try{
        //     $category = new Category();
        //     $category->name = $request->name;
        //     $category->user_id = auth()->id();
        //     $category->reg_id = auth()->id();
        //     $category->token = str_shuffle(md5(date("ymdhis")));
        //     $category->save();
        //     return $this->success($category, 'Category created successfully!', 201);
        // }catch (\Throwable $th){
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }

    public function editCategory ($token) {
        $category = Category::where('token', $token)->first();
        if ( !$category ) {
            return abort(403);
        }
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function updateCategory (Request $request, $token) {
        $category = Category::where('token', $token)->first();
        if ( !$token ) {
            return $this->error(null, 'Category not found!', 403);
        }
        $id = $category->id;

        return $this->CategoryRepository->updateCategory($request, $id);

        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', Rule::unique('categories', 'name')->ignore($id)]
        // ]);
        // if ( $validator->fails() ) {
        //     return $this->error(null, $validator->messages()->first(), 422);
        // }
        // try {
        //     $category = Category::find($id);
        //     $category->name = $request->name;
        //     $category->upd_id = auth()->id();
        //     $category->update();
        //     return $this->success($category, 'Category updated successfully!', 201);
        // }catch (\Throwable $th) {
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }

    public function deleteCategory (Request $request) {

        return $this->CategoryRepository->deleteCategory($request->category_id);

        // try {
        //     $category = Category::find($request->category_id);
        //     $blogs = $category->blogs;
        //     foreach($blogs as $blog) {
        //         $blog->visible = false;
        //         $blog->update();
        //     }
        //     $category->visible = false;
        //     $category->update();
        //     return $this->success(null, 'Category deleted successfully!', 200);
        // }catch (\Throwable $th) {
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }
}
