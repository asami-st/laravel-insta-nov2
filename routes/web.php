<?php

# Regular users
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PasswordController;

# Admin users
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Auth::routes();
    #Note: Auth -> Authentication -- meaning that only the authenticated
    #logged in users can access the route inside the group
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/suggestions', [HomeController::class, 'getAllSuggestedUsers'])->name('suggestions');

        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
        Route::get('/post/{id}/show/', [PostController::class, 'show'])->name('post.show');
        Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.delete');

        # Comment
        Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
        Route::delete('comment/{id}/delete', [CommentController::class, 'destroy'])->name('comment.delete');

        # Profile
        Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
        Route::get('profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

        # Password
        Route::get('/password/{id}/edit', [PasswordController::class, 'edit'])->name('password.edit');
        Route::patch('/password/{id}/update', [PasswordController::class, 'update'])->name('password.update');

        # Like/Unlike
        Route::get('/like/{id}/index', [LikeController::class, 'index'])->name('like.index');
        Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
        Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

        #follow
        Route::post('/follow/{id}', [FollowController::class, 'store'])->name('follow.store');
        Route::delete('/unfollow/{id}', [FollowController::class, 'destroy'])->name('follow.destroy');


        Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
            # Users
            Route::get('/users', [UsersController::class, 'index'])->name('users');  // admin.users | admin/users
            Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');  // admin.users.deactivate
            Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

            #Posts
            Route::get('posts', [PostsController::class, 'index'])->name('posts');  //admin.posts
            Route::delete('posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide'); //admin.posts.hide
            Route::patch('posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');  //admin.posts.unhide

            #Categories
            Route::get('categories', [CategoriesController::class, 'index'])->name('categories');  //admin.categories
            Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
            Route::patch('categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
            Route::delete('categories/{id}/delete', [CategoriesController::class, 'destroy'])->name('categories.delete');
        });

        # Search
        Route::group(['middleware' => 'auth'], function(){
            Route::get('/', [HomeController::class, 'index'])->name('index');
            Route::get('/people', [HomeController::class, 'search'])->name('search');
        });


        // :: -> Scope resolution operator
    });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
