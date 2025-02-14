<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('defaultParameter')->group(function () {

    Route::get('/test', function(){
        return view('admin.test');
    });

    // Home page
    Route::get('/', [PageController::class, 'home'])->name('page.home');
    
    // product list
    Route::get('/product_list',[PageController::class, 'product_list'])->name('product.list');
    Route::get('/productdetail/{id}',[PageController::class, 'productdetail'])->name('page.showproduct');
    
    // add review
    Route::post('/submit_review',[PageController::class, 'submit_review'])->middleware(['auth', 'verified'])->name('submit.review');
    
    // cart
    Route::middleware(['verified'])->get('/view_cart',[PageController::class, 'view_cart'])->name('page.cart');
    Route::get('/checkout',[PageController::class, 'checkout'])->middleware(['auth', 'verified'])->name('page.checkout');
    Route::post('/addtocart/{id}',[PageController::class, 'addtocart'])->middleware(['auth', 'verified'])->name('page.addtocart');
    Route::post('/removetocart/{id}',[PageController::class, 'removetocart'])->middleware(['auth', 'verified'])->name('page.removetocart');
    
    // order list
    Route::get('/myorder_list',[PageController::class, 'myorder_list'])->middleware(['auth', 'verified'])->name('page.orderlist');
    Route::get('/view_order/{id}',[PageController::class, 'vieworder'])->middleware(['auth', 'verified'])->name('page.vieworder');
    
    // my address
    Route::get('/myaddress',[AddressBookController::class, 'myaddress'])->middleware(['auth', 'verified'])->name('address.list');
    Route::get('/deleteaddress/{delid}',[AddressBookController::class, 'deleteAddress'])->middleware(['auth', 'verified'])->name('address.delete');
    Route::post('/addaddress',[AddressBookController::class, 'addAddress'])->middleware(['auth', 'verified'])->name('address.add');
    
    // payment process
    Route::post('/create-order', [PaymentController::class, 'createOrder'])->middleware(['auth', 'verified'])->name('create-order');
    Route::post('/payment-callback', [PaymentController::class, 'paymentCallback'])->middleware(['auth', 'verified'])->name('payment-callback');
    
    // Thank you page
    Route::get('/thankyou',[PageController::class, 'thankyou'])->middleware(['auth', 'verified'])->name('page.thankyou');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
});


require __DIR__.'/auth.php';


// ADMIN CONTROLLER

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('adminAuth')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Category
        Route::get('/category', [AdminController::class, 'categoryList'])->name('categorylist');
        Route::post('/category/{id}', [AdminController::class, 'updateCategory'])->name('updatecategory');
        Route::post('/category', [AdminController::class, 'addCategory'])->name('addcategory');
        Route::get('/deletecategory/{id}', [AdminController::class, 'deleteCategory'])->name('deletecategory');

        // Brand
        Route::get('/brand', [AdminController::class, 'brandList'])->name('brandlist');
        Route::post('/brand/{brandid}', [AdminController::class, 'updateBrand'])->name('updatebrand');
        Route::get('/deletebrand/{id}', [AdminController::class, 'deleteBrand'])->name('deletebrand');
        Route::post('/brand', [AdminController::class, 'addBrand'])->name('addbrand');
        
        // Users
        Route::get('/userlist', [AdminController::class, 'userList'])->name('userlist');
        Route::get('/userview/{userid}', [AdminController::class, 'userView'])->name('userview');

        // Product
        Route::get('/product', [ProductController::class, 'listProduct'])->name('productlist');
        Route::get('/product_new', [ProductController::class, 'newProduct'])->name('productnew');
        Route::post('/add_product', [ProductController::class, 'addProduct'])->name('productadd');
        Route::post('/update_product/{id}', [ProductController::class, 'updateProduct'])->name('productupdate');
        Route::post('/add_productfield/{productid}', [ProductController::class, 'addProductField'])->name('productfield');
        Route::post('/add_productimg/{productid}', [ProductController::class, 'addProductImg'])->name('addproductimg');
        Route::get('/edit_product/{id}', [ProductController::class, 'editProduct'])->name('productedit');
        Route::get('/product_delete/{id}', [ProductController::class, 'deleteProduct'])->name('productdelete');

        // Orders
        Route::get('/orderlist', [AdminController::class, 'orderList'])->name('orderlist');
        Route::get('/orderview/{orderid}', [AdminController::class, 'orderView'])->name('orderview');
        Route::post('/updateorderstatus/{orderid}', [AdminController::class, 'updateOrderStatus'])->name('updateorderstatus');

        // Website Data
        Route::get('/websitedata', [AdminController::class, 'websiteData'])->name('websitedata');
        Route::post('/websitedata', [AdminController::class, 'websiteDataUpdate'])->name('websitedataupdate');

        // test
        Route::get('/test', function(){
            return view('admin.test');
        });

    });
    Route::get('/', [AdminController::class, 'login'])->name('login');
    Route::get('/login', [AdminController::class, 'login']);
    Route::post('/validatelogin', [AdminController::class, 'validateLogin'])->name('validatelogin');
    Route::get('/logout', [AdminController::class, 'destroy'])->name('logout');
});

