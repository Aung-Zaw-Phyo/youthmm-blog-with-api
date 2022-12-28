<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    use HttpResponses;

    private CategoryRepositoryInterface $CategoryRepository;

    public function __construct(CategoryRepositoryInterface $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function categories(){
        $categories = $this->CategoryRepository->getAllCategories();
        return $this->success(CategoryResource::collection($categories), 'Get all categories!', 200);
    }

    public function categoryEntry(Request $request){
        return $this->CategoryRepository->createCategory($request);
    }

    public function updateCategory(Request $request, $id){
        return $this->CategoryRepository->updateCategory($request, $id);
    }

    public function deleteCategory($id){
        return $this->CategoryRepository->deleteCategory($id);
    }
    
}
