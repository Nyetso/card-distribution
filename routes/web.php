<?php

use App\Http\Controllers\DealCardsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('frontend/index'); });

Route::get('/shuffle', [DealCardsController::class, 'shuffleDeck']);
