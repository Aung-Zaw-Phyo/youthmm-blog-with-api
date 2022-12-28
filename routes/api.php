<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------------------------------


Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Api', 'middleware' => 'auth:sanctum'], function  () {
    // blog CRUD 
    Route::group(['prefix' => 'blogs'], function () {
        Route::post('', [BlogApiController::class, 'createBlog']);
        Route::put('/{id}', [BlogApiController::class, 'updateBlog']);
        Route::delete('/{id}', [BlogApiController::class, 'deleteBlog']);
    });
    
    // Category CRUD 
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryApiController::class, 'categories']); //get all categories
        Route::post('/', [CategoryApiController::class, 'categoryEntry']); //create category
        Route::put('/{id}', [CategoryApiController::class, 'updateCategory']); //update category
        Route::delete('/{id}', [CategoryApiController::class, 'deleteCategory']); //delete category
    });
    
    // User ban-action and delete 
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserApiController::class, 'users']); //get all users
        Route::post('/ban/{id}', [UserApiController::class, 'banUser']); //ban user
        Route::post('/cancel_ban/{id}', [UserApiController::class, 'cancel_ban']); //cancel ban user
        Route::delete('/{id}', [UserApiController::class, 'delete_user']); //delete user
    });
    
    // Subscriber read and delete 
    Route::group(['prefix' => 'subscribers'], function () {
        Route::get('/', [UserApiController::class, 'subscribers']); //get all subscribers
        Route::delete('/{id}', [UserApiController::class, 'delete_subscriber']); //delete subscriber
    });
});


// ------------------------




// protected routes 

Route::group(['namespace' => 'App\Http\Controllers\Api', 'middleware' => 'auth:sanctum'], function  () {
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::post('blogs/{id}/comments', [CommentApiController::class, 'createComment']);

});


// pages ui
Route::get('blogs', [BlogApiController::class, 'getAllBlogs']);
Route::get('blogs/latest', [BlogApiController::class, 'latest']);
Route::get('blogs/random', [BlogApiController::class, 'random']);
Route::get('blogs/{id}', [BlogApiController::class, 'getBlogById']);
Route::get('categories/{categoryId}/blogs', [BlogApiController::class, 'getBlogsByCategory']);
Route::get('blogs/search/{search}', [BlogApiController::class, 'searchBlog']);

Route::get('categories', [CategoryApiController::class, 'categories']);

Route::get('author/{id}', [BlogApiController::class, 'getAuthor']);
Route::get('category/{id}', [BlogApiController::class, 'getCategory']);
Route::get('blogs/{id}/comments', [BlogApiController::class, 'getComments']);

// authentication 
Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);
