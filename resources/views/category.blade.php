@extends('layouts.app')

@section('head')
<title>Max Renew - {{ $category['name'] }}</title>
<meta name="description" content="{{ $category['seo_description'] }}">
<meta name="keywords" content="{{ $category['seo_keywords'] }}">
<meta name="author" content="Roark McColgan">
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
<div class="container flex-1 mx-auto pb-8">
	<div class="mt-4 category sm:flex sm:-mx-2">
		@if($category->hasMedia('title'))
		<div class="sm:w-1/3 px-2">
			<img src="{{ $category->getFirstMediaUrl('title', 'category') }}" alt="Image of {{ $category['name'] }}">	
		</div>
		@endif
		<div class="description sm:flex-1 px-2">
			<h1 class="mb-2">{{ $category['name'] }}</h1>
			{!! $category['description'] !!}
		</div>
	</div>
	<div class="flex flex-wrap -mx-2 mt-6 text-base">
		@if(count($category['products']))
		<h3 class="w-full mb-2 px-2">{{ str_singular($category['name']) }} Products</h3>
		@endif
		@foreach($category['products'] as $product)
		<div class="w-1/2 p-2">
			<div class="flex flex-wrap bg-white border shadow p-4">
				<div class="w-1/3">
					<a href="{{'/categories/'.$category['alias'].'/'.$product->alias}}" class="no-underline">
						@if($product->hasMedia('gallery'))
						<img src="{{ $product->getFirstMediaUrl('gallery', 'thumb') }}" alt="Photo of {{ $product->alias }}">
						@endif
					</a>
				</div>
				<div class="w-2/3">
					<div class="mx-4 description">
						<a href="{{'/categories/'.$category['alias'].'/'.$product->alias}}" class="text-max-primary no-underline hover:text-max-secondary">
							<h3 class="mb-2">{{$product['name']}}</h3>
						</a>
						{!! strpos ( $product->description , "</p>" ) !== false ? substr ( $product->description , 0, strpos ( $product->description , "</p>" )+4 ) : str_limit($product->description,80) !!}
						<ul class="mb-4">
							@foreach($product['features'] as $feature)
								<li>{{ $feature->name }}</li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="w-full">
					<hr class="border-t border-grey-light my-4">
					<div class="flex justify-between">
						<div class="text-lg text-max-primary font-bold">
							@money($product['price'],'ZAR')
						</div>
						<div class="">
							<a href="{{'/categories/'.$category['alias'].'/'.$product->alias}}" class="no-underline bg-teal text-white whitespace-no-wrap font-bold py-2 px-4 border-b-4 hover:border-b-2 hover:border-t-2 border-teal-dark hover:border-teal rounded">
								<span class="inline-block text-sm">View</span>
							</a>	
						</div>
					</div>
				</div>
			</div>
		</div>

		@endforeach
	</div>
</div>
@include('partial.footer')
@endsection
