<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeBannerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/checkout', [PageController::class, 'checkout'])->middleware(['auth', 'verified'])->name('checkout');
Route::post('/checkoutpayment', [PageController::class, 'checkoutpayment'])->middleware(['auth', 'verified'])->name('checkoutpayment');
Route::get('/makepayment', [PaymentController::class, 'makepayment'])->middleware(['auth', 'verified'])->name('makepayment');
Route::post('/create-order', [PaymentController::class, 'createOrder'])->middleware(['auth', 'verified'])->name('create-order');
Route::post('/payment-callback', [PaymentController::class, 'paymentCallback'])->middleware(['auth', 'verified'])->name('payment-callback');
Route::get('/thankyou', [PageController::class, 'thankyou'])->middleware(['auth', 'verified'])->name('thankyou');
Route::get('/myorderlist', [PageController::class, 'myorderlist'])->middleware(['auth', 'verified'])->name('myorderlist');

// Route::get('checkout', function () {
// return 'check out page before login';
// })->middleware('auth');

// Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/myaddress', [PageController::class, 'myaddress'])->name('profile.myaddress');
    Route::post('/myaddress', [PageController::class, 'myaddressAdd'])->name('profile.addmyaddress');
    Route::delete('/deletemyaddress', [PageController::class, 'deleteMyAddress'])->name('profile.deletemyaddress');
    Route::patch('/myaddress', [PageController::class, 'myaddress'])->name('profile.myaddress');
    Route::delete('/myaddress', [PageController::class, 'myaddress'])->name('profile.myaddress');
});

require __DIR__.'/auth.php';


/*** Kalaiarasu added  *****/
// Route::middleware(['auth'])->get('/', function () {
//     return view('welcome');
// })->name('home');


/**General user routes **/
// Route::middleware(['auth', 'verified'])->get('/dashboard', [ProfileController::class, 'edit'])->name('dashboard');

if(Auth::user()){
    // Route::get('/', [PageController::class, 'homepage'])->middleware(['auth', 'verified'])->name('home');
    Route::middleware(['auth', 'verified'])->get('/', [PageController::class, 'homepage'])->name('home');
}else{
    Route::get('/', [PageController::class, 'homepage'])->name('home');
}

if(Auth::user()){
    Route::middleware(['auth', 'verified'])->get('/cart', [PageController::class, 'cart'])->name('cart');
}else{
    Route::get('/cart', [PageController::class, 'cart'])->name('cart');
}

Route::get('/product_details/{prodid}', [PageController::class, 'productDetails'])->name('productdetail');
Route::get('/product', [PageController::class, 'product'])->name('product');

Route::post('/savereview', [PageController::class, 'savereview'])->name('savereview');
Route::post('/addtocart', [PageController::class, 'addtocart'])->name('addtocart');
Route::post('/removetocart', [PageController::class, 'removetocart'])->name('removetocart');
// Route::post('/removecart', [PageController::class, 'removecart'])->name('removecart');
Route::post('/updatecart', [PageController::class, 'updatecart'])->name('updatecart');

// routes/web.php
Route::get('/admin', function () {
    return redirect()->route('adminDashboardShow');
});


/**Admin routes **/
Route::middleware('adminAuth')->prefix('admin')->group(function(){
    Route::get('/dashboard', [AdminPageController::class, 'home'])->name('adminDashboardShow');
    Route::get('/homebanner', [HomeBannerController::class, 'homeBanner'])->name('homebanner');
    Route::delete('/homebanner/{id}', [HomeBannerController::class, 'deletebanner'])->name('deletebanner');
    Route::post('/savehomebanner', [HomeBannerController::class, 'store'])->name('savehomebanner');
    Route::get('/feesdetails', [AdminPageController::class, 'feesdetails'])->name('feesdetails');
    Route::delete('/feesdetails/{id}', [AdminPageController::class, 'deletefeesdetails'])->name('deletefeesdetails');
    Route::post('/savefeesdetails', [AdminPageController::class, 'savefeesdetails'])->name('savefeesdetails');
    Route::prefix('category')->group(function(){
        Route::get('/', [AdminPageController::class, 'list'])->name('admincategory');
        Route::get('/new', [AdminPageController::class, 'create'])->name('newcategory');
        Route::post('/store', [AdminPageController::class, 'store'])->name('savecategory');
        Route::get('/edit/{id}', [AdminPageController::class, 'edit'])->name('editcategory');
        Route::post('/update/{id}', [AdminPageController::class, 'update'])->name('updatecategory');
    });
    Route::prefix('products')->group(function(){
        Route::get('/', [ProductController::class, 'list'])->name('productlist');
        Route::get('/new', [ProductController::class, 'create'])->name('newproduct');
        Route::post('/store', [ProductController::class, 'store'])->name('saveproduct');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('editproduct');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('updateproduct');
    });
    Route::prefix('brand')->group(function(){
        Route::get('/', [BrandController::class, 'list'])->name('brandlist');
        Route::get('/new', [BrandController::class, 'create'])->name('newbrand');
        Route::post('/store', [BrandController::class, 'store'])->name('savebrand');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('editbrand');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('updatebrand');
    });
    Route::prefix('order')->group(function(){
        Route::get('/', [AdminPageController::class, 'orderlist'])->name('orderlist');
        Route::get('/new', [BrandController::class, 'create'])->name('newbrand');
        Route::post('/store', [BrandController::class, 'store'])->name('savebrand');
        Route::get('/edit/{id}', [AdminPageController::class, 'orderedit'])->name('editorder');
        Route::post('/update/{id}', [AdminPageController::class, 'orderItemUpdate'])->name('updateorderitem');
    });
    
    Route::get('/users', [AdminPageController::class, 'userlist'])->name('userlist');
    Route::get('/edituser/{id}', [AdminPageController::class, 'useredit'])->name('useredit');

    Route::get('/website', [AdminPageController::class, 'websitedata'])->name('website');
    Route::delete('/website/{id}', [AdminPageController::class, 'deletewebsite'])->name('deletewebsite');
    Route::post('/savewebsite', [AdminPageController::class, 'savewebsite'])->name('savewebsite');
    
});