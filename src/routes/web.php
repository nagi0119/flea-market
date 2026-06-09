<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SellController;

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);

Route::get('/mypage/profile', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'verified']);

Route::post('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'verified']);
Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])
    ->middleware('auth');
Route::get('/item/{item}/order', [OrderController::class, 'create'])
    ->middleware('auth');
Route::post('/item/{item}/order', [OrderController::class, 'store'])
    ->middleware('auth');
Route::post('/item/{item}/comment', [CommentController::class, 'store'])
    ->middleware('auth');
Route::get('/mypage', [ProfileController::class, 'index'])
    ->middleware(['auth', 'verified']);
Route::get('/order/address/{item}', [OrderController::class, 'editAddress'])
    ->middleware('auth');
Route::post('/order/address/{item}', [OrderController::class, 'updateAddress'])
    ->middleware('auth');
Route::get('/sell/create', [SellController::class, 'create'])
    ->middleware('auth');
Route::post('/sell', [SellController::class, 'store'])
    ->middleware('auth');
Route::get('/order/success/{item}', [OrderController::class, 'success'])
    ->middleware('auth');
