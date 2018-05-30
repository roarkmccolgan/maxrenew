<?php

use App\Category;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

//Auth0
Route::get('/login', 'Auth0Controller@login');
Route::get('/logout', 'Auth0Controller@logout');
Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback');

Route::get('/contact', function () {
    return view('contact');
});
Route::post('/contact', 'ContactController@SendMessage');

Route::get('/terms', function(){
	return view('terms');
});

Route::get('/', 'ShopController@getHome');
Route::get('/categories/{tree?}', 'ShopController@getProductOrCategory')->where('tree', '(.*)');

Route::get('/checkout', 'CheckoutController@showCheckout');
Route::post('/checkout', 'CheckoutController@Checkout');

Route::get('/productlist', 'ShopController@jsonList');

Route::post('/productfrompdf', 'DataBaseController@productfrompdf');
Route::post('/categoryfrompdf', 'DataBaseController@categoryfrompdf');

Route::get('/media/category/{category}/{file}', function($category, $file){
	$cat = \App\Category::find($category);
	$cat->addMedia(storage_path('source_images/'.$file))->preservingOriginal()->toMediaCollection('title');
	
	return 'success';
});
Route::get('/media/product/{product}/{file}', function($product, $file){
	$prod = \App\Product::find($product);
	$prod->addMedia(storage_path('source_images/'.$file))->preservingOriginal()->toMediaCollection('title');
	
	return 'success';
});

Route::get('/listcategories', function(){
	$categories = Category::with(['products','allSubCategories.products'])->orderBy('order')->where('parent_id',null)->get();
	return $categories;
});

Route::get('/testmail', function(){
	$order = Order::with(['items','contact'])->find(11);
	
	/*Mail::to('roarkmccolgan@gmail.com')
	->send(new App\Mail\SendOrder($order));*/

    return (new App\Mail\SendOrder($order))->render();
});

Route::get('/user/{user}', 'UserController@search');

Route::prefix('api')->group(function () {
    Route::post('cart', 'CartController@addToCart');
    Route::get('clearcart', 'CartController@clearCart');
    Route::post('checkout', 'CheckoutController@saveCheckout');

    Route::post('question', 'QAController@create');
    Route::post('answer', 'QAController@answerQuestion');

});