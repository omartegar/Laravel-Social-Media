<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PublicChatController;





Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'destroy']);
Route::get('/signup', [SignUpController::class, 'index']);
Route::post('/signup', [SignUpController::class, 'store']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/postcreate', [PostController::class, 'index']);
Route::post('/postData', [PostController::class, 'store']);
Route::delete('/postData', [PostController::class, 'destroy']);

Route::get('/chat', [ChatController::class, 'index']);
Route::get('/chat_index_messages', [ChatController::class, 'index_messages']);
Route::post('/chat', [ChatController::class, 'show']);
Route::post('/send', [ChatController::class, 'store']);

Route::get('/public_chat', [PublicChatController::class, 'index']);
Route::get('/public_chat_index_messages', [PublicChatController::class, 'index_messages']);
Route::post('/public_chat', [PublicChatController::class, 'store']);

Route::post('/like_post', [LikeController::class, 'store']);
Route::delete('/dislike_post', [LikeController::class, 'destroy']);
