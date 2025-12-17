<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\AdminController;

// PUBLIC / PATRON ROUTES 
Route::get('/', [LibraryController::class, 'index'])->name('catalog');
Route::post('/borrow', [LibraryController::class, 'storeRequest'])->name('borrow.request');

// Patron Personal History & Actions
Route::get('/my-history', [LibraryController::class, 'patronHistory'])->name('patron.history');
Route::post('/borrow/extend/{id}', [LibraryController::class, 'extendDueDate'])->name('borrow.extend');

// LIBRARIAN ROUTES
Route::get('/librarian', [LibraryController::class, 'adminDashboard'])->name('librarian.dashboard');

// Borrowing Actions
Route::get('/approve/{id}', [LibraryController::class, 'approveRequest'])->name('borrow.approve');
Route::get('/decline/{id}', [LibraryController::class, 'declineRequest'])->name('borrow.decline');
Route::get('/return/{id}', [LibraryController::class, 'returnBook'])->name('borrow.return');

// Book Management (CRUD)
Route::get('/books', [LibraryController::class, 'bookIndex'])->name('books.index');
Route::get('/books/create', [LibraryController::class, 'createBook'])->name('books.create');
Route::post('/books', [LibraryController::class, 'storeBook'])->name('books.store');
Route::get('/books/{id}/edit', [LibraryController::class, 'editBook'])->name('books.edit');
Route::put('/books/{id}', [LibraryController::class, 'updateBook'])->name('books.update');
Route::delete('/books/{id}', [LibraryController::class, 'destroyBook'])->name('books.destroy');

// ADMINISTRATOR ROUTES
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings');
Route::post('/admin/patron', [AdminController::class, 'storePatron'])->name('admin.patron.store');
Route::get('/admin/patron/delete/{id}', [AdminController::class, 'deletePatron'])->name('admin.patron.delete');
Route::post('/admin/librarian', [AdminController::class, 'storeLibrarian'])->name('admin.librarian.store');
Route::get('/admin/librarian/delete/{id}', [AdminController::class, 'deleteLibrarian'])->name('admin.librarian.delete');
Route::get('/admin/cleanup', [AdminController::class, 'cleanupRecords'])->name('admin.cleanup');