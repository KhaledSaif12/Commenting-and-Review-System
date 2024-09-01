<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ContentReviews;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikescommentsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Grouping routes for likes and dislikes
Route::group(['middleware'=>'auth'], function () {




    // Add a new like/dislike
    Route::post('/store', [LikescommentsController::class, 'store'])->name('likescomments.store');

    // Update an existing like/dislike
    Route::put('/update/{id}', [LikescommentsController::class, 'update'])->name('likescomments.update');

    // Delete a like/dislike
    Route::delete('/destroy/{id}', [LikescommentsController::class, 'destroy'])->name('likescomments.destroy');

    // Toggle like for a specific content
    Route::post('/toggle-like/{contentId}', [LikescommentsController::class, 'toggleLike'])->name('likescomments.toggleLike');

    // Toggle dislike for a specific content
    Route::post('/toggle-dislike/{contentId}', [LikescommentsController::class, 'toggleDislike'])->name('likescomments.toggleDislike');

    // Get total likes for a specific content
    Route::get('/total-likes/{contentId}', [LikescommentsController::class, 'getTotalLikes'])->name('likescomments.totalLikes');

    // Get total dislikes for a specific content
    Route::get('/total-dislikes/{contentId}', [LikescommentsController::class, 'getTotalDislikes'])->name('likescomments.totalDislikes');

Route::post('/content/{id}/like', [LikescommentsController::class, 'toggleLike'])->name('likescomments.toggleLike');
Route::post('/content/{id}/dislike', [LikescommentsController::class, 'toggleDislike'])->name('likescomments.toggleDislike');

});


Route::group(['middleware'=>'auth'], function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    // Route to show the profile edit form
    Route::get('/profile/edit/{id}', [UserController::class, 'editProfile'])->name('edit.profile');

    // Route to handle profile updates
    Route::post('/profile/edit/{id}', [UserController::class, 'updateProfile'])->name('update.profile');


    //reviews

    Route::post('/reviews', [ContentReviews::class, 'store'])->name('reviews');
Route::get('/comments/{id}/edit', [ContentReviews::class, 'edit'])->name('comments.edit');
Route::put('/comments/{id}', [ContentReviews::class, 'update'])->name('comments.update');
Route::delete('/comments/{id}', [ContentReviews::class, 'destroy'])->name('comments.destroy');


// إضافة إعجاب جديد
Route::post('/likes', [LikesController::class, 'store'])->name('likes.store');

// تحديث إعجاب موجود
Route::put('/likes/{id}', [LikesController::class, 'update'])->name('likes.update');

// حذف إعجاب
Route::delete('/likes/{id}', [LikesController::class, 'destroy'])->name('likes.destroy');

// الإعجاب وعدم الإعجاب
Route::post('/likes/toggle/{commentId}', [LikesController::class, 'toggleLike'])->name('likes.toggle');
Route::post('/dislikes/toggle/{commentId}', [LikesController::class, 'toggleDislike'])->name('dislikes.toggle');

});
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'CreatUser'])->name('register');
Route::post('/saveuser',[AuthController::class,'store'])->name('save_user_old');
Route::post('/check_usar',[AuthController::class,'checkUser'])->name('check_usar');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/content/{id}', [ContentReviews::class, 'show'])->name('content.show');


// عرض جميع الإعجابات
Route::get('/likes', [LikesController::class, 'index'])->name('likes.index');

// عرض الإعجاب حسب المعرف
Route::get('/likes/{id}', [LikesController::class, 'show'])->name('likes.show');


