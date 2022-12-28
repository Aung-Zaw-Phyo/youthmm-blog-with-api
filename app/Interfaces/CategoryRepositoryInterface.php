<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();

    public function createCategory($request);

    public function updateCategory($request, $categoryId);

    public function deleteCategory($categoryId);

}
