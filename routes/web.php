<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Livewire\Counter;

// user account page
Route::middleware('auth')->group(function(){
   Route::get('/account',[AccountController::class,'manage'])
   ->name('account.manage');
   Route::post('/account/delete',[AccountController::class,'delete'])
   ->name('account.delete');
   Route::post('/account/password',[AccountController::class,'changePassword'])
   ->name('account.password');
   Route::post('/account/email',[AccountController::class,'changeEmail'])
   ->name('account.email');
});

// admin only
Route::middleware(['auth','admin'])
   ->prefix('admin')
   ->name('admin.')
   ->group(function(){
      Route::get('/', function(){
            return view('admin.dashboard');
      })->name('dashboard');
      Route::get('/posts',[AdminPostController::class,'index'])->name('posts.index');
      
      Route::get('/posts/{post}/edit',[AdminPostController::class, 'edit'])->
      name('posts.edit');
      Route::patch('/posts/{post}',[AdminPostController::class, 'update'])->name('posts.update');
      Route::delete('/posts/{post}',[AdminPostController::class, 'destroy'])->name('posts.destroy');
      Route::get('/users',[AdminUserController::class,'index'])->name('users.index');
      Route::patch('/users/{user}/ban',[AdminUserController::class,'ban'])->name('users.ban');
      Route::patch('/users/{user}/unban',[AdminUserController::class,'unban'])->name('users.unban');
      Route::delete('/users/{user}/avatar',[AdminUserController::class,'destroyAvatar'])->name('users.avatar.destroy');
      Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
   });

// user related 
Route::get('/', [UserController::class,"showCorrectHomepage"])->name('login');
Route::post('/register',[UserController::class,'register'])->middleware('guest');
Route::post('/login',[UserController::class,'login'])->middleware('guest');
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');
Route::get('/manage-avatar', [UserController::class,'showAvatarForm'])->middleware('auth');
Route::post('/manage-avatar', [UserController::class,'storeAvatar'])->middleware('auth');
Route::get('/users',[UserController::class,'index'])->name('users.index');

// follow related routes
Route::post('/create-follow/{user:username}', 
[FollowController::class,'createFollow'])->middleware('auth');
Route::post('/remove-follow/{user:username}', 
[FollowController::class,'removeFollow'])->middleware('auth');

// blog post related
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost'])->name('post.show');
Route::delete('/post/{post}',[PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'actuallyUpdate'])->middleware('can:update,post');
Route::get('/posts',[PostController::class,'index'])->name('posts.index');
Route::post('/trix-image-upload',[PostController::class,'uploadTrixImage'])->middleware('auth');

// comment related
Route::post('/posts/{post}/comments',[CommentController::class,'store'])->middleware('auth')->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class,'destroy'])->middleware('auth')->name('comments.destroy');

// search 
Route::get('/search',[SearchController::class,'index'])->name('search.index');

// profile related 
Route::get('/profile/{user:username}',[UserController::class, 'profile'])->name('profile.show');
Route::get('/profile/{user:username}/followers',[UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following',[UserController::class, 'profileFollowing']);

/*
// chat 
Route::post('/send-chat-message',function(Request $request){
 $formFields = $request->validate([
    'textvalue' => 'required'
 ]);
 if(!trim(strip_tags($formFields['textvalue']))){
    return response()->noContent();
 }
 broadcast(new ChatMessage(['username'=>auth()->user()->username, 'textvalue' => strip_tags($request->textvalue), 'avatar'=> auth()->user()->avatar]))->toOthers();
 return response()->noContent();
})->middleware('auth');

*/