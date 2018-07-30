<?php

namespace App\Http\Controllers;

use App\Category;
use App\Features;
use App\Product;
use App\Specs;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataBaseController extends Controller
{
	public function productfrompdf(Request $request){
		Log::info('Submitted Data : '.print_r($request->all(), true));
		$error = false;
		$message = '';
		if (!$request->has(['product.sku', 'product.name', 'product.price'])) {
			$error = true;
			$message = 'ERROR!: SKU, Name and Price are required';
		}
		$attachProducts = [];

		if($request->has('pack') && count($request->input('pack'))>0){
			foreach ($request->input('pack') as $pack) {
				$packItem = Product::where('sku',$pack['sku'])->first();
				if($packItem){
					$attachProducts[$packItem->id] =  ['qty' => $pack['qty']];
				}else{
					$error = true;
					$message = 'ERROR!:\n Pack Item not found\n Please add '.$pack['sku'];
					break;
				}
			}
		}

		Log::info('Attach : '.print_r($attachProducts, true));

		if(!$error){

			$categories =[];
			foreach ($request->input('categories') as $cat) {
				if(isset($cat['category'])){
					$category = Category::firstOrCreate(
						['alias' => str_slug($cat['category'])],
						['name' => $cat['category']]
					);
					$categories[] = $category->id;
					if(isset($cat['sub-category'])){
						$subCategory = Category::firstOrCreate(
							['alias' => str_slug($cat['sub-category']), 'parent_id'=>$category->id],
							['name' => $cat['sub-category']]
						);
						$categories[] = $subCategory->id;
						if(isset($cat['sub-sub-category'])){
							$subSubCategory = Category::firstOrCreate(
								['alias' => str_slug($cat['sub-sub-category']), 'parent_id'=>$subCategory->id],
								['name' => $cat['sub-sub-category']]
							);
							$categories[] = $subSubCategory->id;
						}
					}
				}
			}

			$newProduct = $request->input('product');

			$product = Product::updateOrCreate(
				['sku' => $newProduct['sku']],
				[
					'name' => $newProduct['name'],
					'alias' => str_slug($newProduct['name']),
					'strapline' => isset($newProduct['short_description']) ? $newProduct['short_description'] : null,
					'description' => isset($newProduct['description']) ? Markdown::convertToHtml($newProduct['description']) : null,
					'price' => $newProduct['price']*100,
					'price_install' => isset($newProduct['price_install']) ? $newProduct['price_install']*100 : null,
					'seo_title' => (isset($newProduct['seo']) && isset($newProduct['seo']['title'])) ? $newProduct['seo']['title'] : null,
					'seo_keywords' => (isset($newProduct['seo']) && isset($newProduct['seo']['keywords'])) ? $newProduct['seo']['keywords'] : null,
					'seo_description' => (isset($newProduct['seo']) && isset($newProduct['seo']['description'])) ? $newProduct['seo']['description'] : null,
				]
			);
			if(count($categories)>0){
				$product->categories()->sync($categories);
			}
			if(count($attachProducts)>0){
				$product->products()->sync($attachProducts);
			}

			if($request->has('content')) {
				$product->clearMediaCollection('content');				
				foreach ($request->input('content') as $content) {
					$content = str_replace("dl=0","raw=1",$content);
					$parts = parse_url($content); 
					$slug_name = str_replace(['%20','?raw=1'],['-',''],basename($parts['path']));
					Log::info($slug_name);
					$file_name = str_replace(['%20','-','_','.jpg','.JPG','.JPEG','.png','.png'],[' ',' ',' ','','','','',''],basename($parts['path']));
					Log::info($file_name);
					$product->addMediaFromUrl($content)->usingFileName($slug_name)->usingName($file_name)->toMediaCollection('content');
				}
				$mediaItems = $product->getMedia('content');
				$replaceImages = [];
				$replaceURLS = [];
				foreach ($mediaItems as $key => $item) {
					$replaceImages[]='img_'.$key;
					$replaceURLS[]='!['.$item->name.']('.$item->getUrl().' "'.$item->name.'")';

					$replaceImages[]='img_'.$key;
					$replaceURLS[]='!['.$item->name.']('.$item->getUrl().' "'.$item->name.'")';
				}
				if($request->has('description')){
					$newDescription = str_replace($replaceImages, $replaceURLS, $request->input('description'));
					$product->description = Markdown::convertToHtml($newDescription);
				}
				$product->save();
			}
			if($request->has('gallery')) {
				$product->clearMediaCollection('gallery');
				foreach ($request->input('gallery') as $gallery) {
					$gallery = str_replace("dl=0","raw=1",$gallery);
					$parts = parse_url($gallery); 
					$slug_name = str_replace(['%20','?raw=1'],['-',''],basename($parts['path']));
					Log::info($slug_name);
					$file_name = str_replace(['%20','-','_','.jpg','.JPG','.JPEG','.png','.png'],[' ',' ',' ','','','','',''],basename($parts['path']));
					Log::info($file_name);
					$product->addMediaFromUrl($gallery)->usingFileName($slug_name)->usingName($file_name)->toMediaCollection('gallery');
				}
			}
			if($request->has('applications')) {
				$product->clearMediaCollection('applications');
				foreach ($request->input('applications') as $applications) {
					$applications = str_replace("dl=0","raw=1",$applications);
					$parts = parse_url($applications); 
					$slug_name = str_replace(['%20','?raw=1'],['-',''],basename($parts['path']));
					Log::info($slug_name);
					$file_name = str_replace(['%20','-','_','.jpg','.JPG','.JPEG','.png','.png','.pdf'],[' ',' ',' ','','','','','',''],basename($parts['path']));
					Log::info($file_name);
					$product->addMediaFromUrl($applications)->usingFileName($slug_name)->usingName($file_name)->toMediaCollection('applications');
				}
			}
			if($request->has('technical')) {
				$product->clearMediaCollection('technical');
				foreach ($request->input('technical') as $technical) {
					$technical = str_replace("dl=0","raw=1",$technical);
					$parts = parse_url($technical); 
					$slug_name = str_replace(['%20','?raw=1'],['-',''],basename($parts['path']));
					Log::info($slug_name);
					$file_name = str_replace(['%20','-','_','.jpg','.JPG','.JPEG','.png','.png','.pdf'],[' ',' ',' ','','','','','',''],basename($parts['path']));
					Log::info($file_name);
					$product->addMediaFromUrl($technical)->usingFileName($slug_name)->usingName($file_name)->toMediaCollection('technical');
				}
			}

			if(isset($newProduct['feature'])){
				$product->features()->delete();
				foreach ($newProduct['feature'] as $feature) {
					Features::create(['name'=>$feature,'product_id'=>$product->id]);
				}
			}
			if(isset($newProduct['spec']) && count($newProduct['spec'])>0){
				$product->specs()->delete();
				foreach ($newProduct['spec'] as $spec) {
					Specs::create(['spec'=>$spec['spec'], 'value'=>$spec['value'],'product_id'=>$product->id]);
				}
			}
			$message = 'Success!\n'.$product->name.'-'.$product->sku.' Successfully Saved';
		}
		$response = "%FDF-1.2\r\n" .
		"1 0 obj<< /FDF << /Status ($message) >>      >>endobj\r\n" .
		"trailer\r\n" .
		"<< /Root 1 0 R >>%%EOF";
		return response($response)->header('Content-Type', 'application/vnd.fdf');
	}

	public function categoryfrompdf(Request $request){
		Log::info('Submitted Data : '.print_r($request->all(), true));
		$error = false;
		$message = '';
		if (!$request->has(['category', 'description'])) {
			$error = true;
			$message = 'ERROR!: Category and Description are required';
		}

		$category = Category::where('alias', str_slug($request->input('category')))->first();
		if (!$category) {
			$error = true;
			$message = 'ERROR!: Category does not exist yet\n\n Please add a product to the category before you can edit the category';
		}

		if(!$error){
			$category->description = Markdown::convertToHtml($request->input('description'));
			$category->seo_title = $request->input('seo.title');
			$category->seo_description = $request->input('seo.description');
			$category->seo_keywords = $request->input('seo.keywords');
			$category->save();

			$message = 'Success!\n'.$category->name.' Successfully Saved';
		}
		if($request->has('image')) {
			$product->clearMediaCollection('title');
			$title = str_replace("dl=0","raw=1",$title);
			$parts = parse_url($title); 
			$slug_name = str_replace(['%20','?raw=1'],['-',''],basename($parts['path']));
			Log::info($slug_name);
			$file_name = str_replace(['%20','-','_','.jpg','.JPG','.JPEG','.png','.png'],[' ',' ',' ','','','','',''],basename($parts['path']));
			Log::info($file_name);
			$product->addMediaFromUrl($title)->usingFileName($slug_name)->usingName($file_name)->toMediaCollection('title');
		}
		$response = "%FDF-1.2\r\n" .
		"1 0 obj<< /FDF << /Status ($message) >>      >>endobj\r\n" .
		"trailer\r\n" .
		"<< /Root 1 0 R >>%%EOF";
		return response($response)->header('Content-Type', 'application/vnd.fdf');
	}
}
