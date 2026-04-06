<?php

use App\Http\Controllers\PublicAboutController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\PublicInstanceController;
use App\Livewire\Form;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicEventController::class, 'home'])->name('home');
Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');

Route::get('/instances', [PublicInstanceController::class, 'index'])->name('instances.index');
Route::get('/instances/{instance}', [PublicInstanceController::class, 'show'])->name('instances.show');

Route::get('/annonces', [PublicAnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/annonces/{announcement:slug}', [PublicAnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/a-propos', PublicAboutController::class)->name('about');
Route::view('/faq', 'public.faq')->name('faq');

Route::get('form', Form::class);
Route::redirect('login-redirect', 'login')->name('login');
