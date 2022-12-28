<?php

namespace App\Interfaces;

interface BlogRepositoryInterface
{
    public function getAllBlogs($count = 6);

    public function getBlogById($blogId);

    public function searchBlog($search);

    public function deleteBlog($blogId);

    public function createBlog($request);

    public function updateBlog($request, $blogId);

    public function getBlogsByCategory ($categoryId);

}
