<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
   
    public function getHome(Request $request){
        
        //DB::connection()->enableQueryLog();
        //$cats = Category::with(['products:alias,name','allSubCategories.products:alias,name'])->where('parent_id',null)->get();
        //return DB::getQueryLog();
        //return $cats;
    	//$shop = collect(Config::get('maxrenew.categories'));
      
        \JavaScript::put([
            'cart' => session('cart'),
        ]);
        
    	return view('home',compact(['cart']));
    }

    public function getCategories($cat){
    	$category = collect(Config::get('maxrenew.categories.'.$cat));
    	return view('category',compact('category'));
    }
    public function getProduct($cat, $product){
        $product = Product::where('alias',$product)->get();
        return view('product',compact(['product']));
    }
    public function getProductOrCategory(Request $request, $tree = null){
        //return session('cart');
        if($tree){
            $path = explode('/', $tree);
            $last = last($path);
            if(count($path)===1){
                $category = Category::with('products')->where('alias',$last)->firstOrFail();
                return view('category',compact('category'));
            }
            $category = Category::with(['products'])->where('alias',$path[count($path)-2])->firstOrFail();
            $product = Product::with(['products','questions.answers'])->where('alias',$last)->firstOrFail();
            //return $product;
            $isLoggedIn = Auth::check();
            $user = $isLoggedIn ? Auth::user()->getUserInfo() : false;
            \JavaScript::put([
                'product' => $product,
                'cart' => session('cart'),
                'user' => $user,
            ]);
            return view('product',compact(['product','category']));
        }
        abort(404);
    }

    public function jsonList(){
        $database = Config::get('maxrenew');
    	$products = collect($database)->map(function ($item, $key) {
            return collect($item)->map(function($category, $catKey){
                return collect($category['products'])->map(function ($product, $prodKey) use($catKey){
                    return collect($product)->only(['name','alias','description'])->put('url',env('APP_URL').'/categories/'.$catKey.'/'.$prodKey);
                });
            });
        })->flatten(2);
        return response()->json($products);
    }
}
