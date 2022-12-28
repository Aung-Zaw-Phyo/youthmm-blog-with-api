<?php

use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Pages\AuthController;
use App\Http\Controllers\Pages\PagesController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['admin'])->group(function () {
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [AdminBlogController::class, 'index'])->name('blogs');
        Route::get('/add', [AdminBlogController::class, 'addBlog'])->name('addBlog');
        Route::post('/add', [AdminBlogController::class, 'blogEntry'])->name('blogEntry');
        Route::get('/{token}/view', [AdminBlogController::class, 'viewBlog'])->name('viewBlog');
        Route::get('/{token}/edit', [AdminBlogController::class, 'editBlog'])->name('editBlog');
        Route::post('/{token}/update', [AdminBlogController::class, 'updateBlog'])->name('updateBlog');
        Route::post('/delete', [AdminBlogController::class, 'deleteBlog'])->name('deleteBlog');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [AdminCategoryController::class, 'categories'])->name('categories');
        Route::get('/add', [AdminCategoryController::class, 'addCategory'])->name('addCategory');
        Route::post('/add', [AdminCategoryController::class, 'categoryEntry'])->name('categoryEntry');
        Route::get('/{token}/edit', [AdminCategoryController::class, 'editCategory'])->name('editCategory');
        Route::post('/{token}/update', [AdminCategoryController::class, 'updateCategory'])->name('updateCategory');
        Route::post('/delete', [AdminCategoryController::class, 'deleteCategory'])->name('deleteCategory');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [AdminUserController::class, 'users'])->name('users');
        Route::post('/ban', [AdminUserController::class, 'banUser'])->name('banUser');
        Route::post('/cancel_ban', [AdminUserController::class, 'cancel_ban'])->name('cancel_ban');
        Route::post('/delete', [AdminUserController::class, 'delete_user'])->name('delete_user');
    });
    Route::group(['prefix' => 'subscribers'], function () {
        Route::get('/', [AdminUserController::class, 'subscribers'])->name('subscribers');
        Route::post('/delete', [AdminUserController::class, 'delete_subscriber'])->name('delete_subscriber');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{token}/comment', [PagesController::class, 'comment'])->name('comment');
    Route::get('/profile', [PagesController::class, 'profile'])->name('profile');

});

Route::get('/', [PagesController::class, 'home'])->name('page_home');
Route::get('/posts', [PagesController::class, 'posts'])->name('page_posts');
Route::get('/posts/{token}', [PagesController::class, 'viewPost'])->name('page_viewPost');

Route::get('/login', [PagesController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [PagesController::class, 'register'])->name('register')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('post_login');
Route::post('/register', [AuthController::class, 'register'])->name('post_register');
Route::post('logout', [AuthController::class, 'logout'])->name('post_logout');
Route::post('/subscribe', [AuthController::class, 'subscribe'])->name('subscribe');

Route::post('/profile/update/profile', [AuthController::class, 'updateProfile'])->name('updateProfile');
Route::post('/profile/update/name', [AuthController::class, 'updateName'])->name('updateName');
Route::post('/profile/update/email', [AuthController::class, 'updateEmail'])->name('updateEmail');


Route::get('/test', function () {
    $users = \App\Models\User::all();
    // $diffTime = now()->diffInMinutes($user->created_at);
    // dd(($diffTime / 60) / 24);
    // dd($user->created_at->addDays(550));

    return view('test', [
        'users' => $users
    ]);
});

Route::get('/mail', function () {
    \Illuminate\Support\Facades\Mail::to('aungzawphyo@gmail.com')->send(new \App\Mail\SubscriberMail());
});
