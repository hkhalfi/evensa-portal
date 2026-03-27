<?php

use App\Http\Controllers\PublicEventController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;

Route::get('form', Form::class);
Route::redirect('login-redirect', 'login')->name('login');

Route::get('/', [PublicEventController::class, 'home'])->name('public.home');
Route::get('/events', [PublicEventController::class, 'index'])->name('public.events.index');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('public.events.show');
