<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminGameController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MyGamesController;
use App\Http\Controllers\UserPurchaseHistoryController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/landing', [LandingController::class, 'index']);

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/trending', [TrendingController::class, 'index'])->name('trending');

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/catalogue', [GameController::class, 'index'])->name('catalogue');
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/{game}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{game}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{game}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/payment/{transaction}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{transaction}/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::patch('/payment/{transaction}/method', [PaymentController::class, 'updateMethod'])->name('payment.updateMethod');
    Route::get('/my-games', [MyGamesController::class, 'index'])->name('user.my-games');
    Route::get('/purchase-history', [UserPurchaseHistoryController::class, 'index'])->name('user.purchase-history.index');
    Route::get('/purchase-history/{transaction}', [UserPurchaseHistoryController::class, 'show'])->name('user.purchase-history.detail');
    Route::get('/purchase-history/{transaction}/receipt', [UserPurchaseHistoryController::class, 'receipt'])->name('user.purchase-history.receipt');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/wishlist/{game}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('games', AdminGameController::class)->except(['show']);
    Route::resource('transactions', AdminTransactionController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
    Route::get('/transactions/{transaction}/export/pdf', [AdminTransactionController::class, 'exportPdf'])->name('transactions.exportPdf');
    Route::get('/transactions/export/pdf', [AdminTransactionController::class, 'exportAllPdf'])->name('transactions.exportPdfAll');
    Route::get('/transactions/export/excel', [AdminTransactionController::class, 'exportExcel'])->name('transactions.exportExcel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
