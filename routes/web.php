<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

/* use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; */

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\products\ProductController as AdminProductController;




use App\Http\Controllers\products\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\CheckoutController;



// Default Redirect


Route::get('/', function () {
    return redirect()->route('account.login');
});

//| USER AUTH ROUTES

Route::prefix('account')->group(function () {

    // Guest
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated User
    Route::middleware('auth:web')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
        Route::get('edit', [DashboardController::class, 'edit'])->name('account.edit');
        Route::post('update', [DashboardController::class, 'update'])->name('account.update');
        Route::post('delete', [DashboardController::class, 'delete'])->name('account.delete');
        Route::post('logout', [LoginController::class, 'logout'])->name('account.logout');
    });
});


/*
|--------------------------------------------------------------------------
| USER CART & CHECKOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::get('admin/user/{user}/orders', [OrderController::class, 'userOrders'])->name('admin.user.orders');
    Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [CartController::class, 'placeOrder'])->name('place.order');
    Route::get('/user/orders/success', [OrderController::class, 'success'])->name('user.orders.success');
    Route::get('/user/orders/{order}/download', [OrderController::class, 'downloadBill'])->name('user.orders.download');
    Route::get('user/orders', [OrderController::class, 'myOrders'])->name('user.orders');
        Route::get('/user/orders/{order}/success', [OrderController::class, 'downloadBill'])->name('user.orders.success');

});

// ADMIN ROUTES

/* Route::prefix('admin')->group(function () {

    // Admin Guest
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    // Admin Authenticated
    Route::middleware('admin.auth')->prefix('admin')->group(function () {

        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/user/{user}/orders',[OrderController::class, 'userOrders'])->name('admin.user.orders');

        // Products
        Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
         Route::post('products/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
        Route::post('products/{id}/delete', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Orders / Bills
        Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');

        // Logout
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
}); */

/* // Admin Routes
Route::prefix('admin')->group(function () {

    // Admin Guest Routes (Login)
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    // Admin Authenticated Routes
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Products CRUD
        Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('products/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
        Route::post('products/{id}/delete', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

        // user orders edit or delete by user
        Route::get('orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

        // User-specific Orders
        Route::get('user/{user}/orders', [AdminOrderController::class, 'userOrders'])->name('admin.user.orders');

        // Logout
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });

}); */


Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Guest Routes
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('authenticate');
        Route::get('users/{id}/edit', [AdminDashboardController::class, 'edit'])
    ->name('users.edit');

Route::post('users/{id}/update', [AdminDashboardController::class, 'update'])
    ->name('users.update');

Route::post('users/{id}/delete', [AdminDashboardController::class, 'delete'])
    ->name('users.delete');
    });

    // Admin Authenticated Routes
    Route::middleware('admin.auth')->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products CRUD
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('products/{id}/update', [ProductController::class, 'update'])->name('products.update');
        Route::post('products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // User orders edit
        Route::get('orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit'); // ✅ Now name: admin.orders.edit
        Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');  // ✅ admin.orders.update
         Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');



Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');


        // User-specific Orders
        Route::get('user/{user}/orders', [AdminOrderController::class, 'userOrders'])->name('user.orders');

        // Logout
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});