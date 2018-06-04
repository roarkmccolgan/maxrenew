@extends('layouts.app')

@section('head')
<title>Max Renew - {{ $product->name }}</title>
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
<div class="container flex-1 mx-auto pb-8">
	<div class="mt-6 p-4 bg-white border-t border-b sm:border sm:shadow">
		<div class="sm:flex -mx-2">
			<div class="sm:w-1/3 p-2">
				@if($product->hasMedia('title'))
				<img src="{{ $product->getFirstMediaUrl('title', 'product') }}" alt="Image of {{ $product['name'] }}">
				@endif
			</div>
			<div class="sm:w-1/3 p-2">
				<div class="mx-4">
					<h1 class="mb-4">{{ $product->name }}</h1>
					<p class="mb-2">{{ $product->description }}</p>
					<ul class="mb-4">
						@foreach($product->features as $feature)
						<li>{{ $feature->name }}</li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="sm:w-1/3 p-2 pt-8">
				<div class="flex flex-col ml-4">
					<form action="/api/cart" method="post" class="mt-6" @submit.prevent="addToCart()">
						<input type="hidden" value="" name="sku" v-model="product.sku">
						<div class="font-bold text-4xl mb-2">
							@if(count($product->products))
							<div class="text-sm font-medium text-grey-dark">
								Kit only price
							</div>
							@endif
							@money($product->price,'ZAR')
							<span class="text-sm font-medium text-grey-dark">
								inc.Vat
							</span>
						</div>
						@if(count($product->products))
						<div class="font-bold text-sm mb-4 rounded bg-grey-lighter px-4 py-2">
							<span class="font-medium">
								Have it installed by a proffessional
							</span>
							<label class="block mt-2">
								<input class="mr-2" type="checkbox" name="installation" :checked="product.price_install" v-model="product.install">
								<span class="">
									only @money($product->price_install,'ZAR') extra
								</span>
							</label>
						</div>
						@endif
						<div class="flex flex-wrap items-center">
							<div class="w-1/2">
								QTY <input name="qty" type="number" v-model="product.qty" class="shadow appearance-none border rounded py-2 px-3 text-grey-darker w-16">
							</div>
							<div class="w-1/2">
								<button class="bg-max-secondary text-white whitespace-no-wrap font-bold py-4 px-4 border-b-4 hover:border-b-2 hover:border-t-2 border-teal-darker hover:border-max-secondary rounded">
									<div class="inline-block w-6 mr-1">
										<transition name="component-bounce" mode="out-in">
											<font-awesome-icon :icon="busyAdding ? icons.loading : icons.mouse" class="fa-lg" :class="busyAdding ? 'fa-spin' : ''" v-bind:key="busyAdding"></font-awesome-icon>
										</transition>
										</div>
									<span class="inline-block">Add to cart</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
	<div class="mt-6 -mx-2">
		<tabs>
			<tab name="Q &amp; A" class="-mb-px mr-1">
				<question-component :questions="product.questions" :product-id="product.id" :user="user"></question-component>
			</tab>
			@if($product->specs)
			<tab name="Specifications">
				<table class="w-full text-sm text-left" cellpadding="0" cellspacing="0">
					<thead class="font-medium text-xs text-grey-dark uppercase border-grey">
						<tr>
							<th class="w-1/2 sm:w-1/5 text-right p-2 border-b bg-grey-lighter">Property <hr class="inline-block h-px border-t w-2 h-0 m-0 ml-2 mb-1"></th>
							<th class="text-left p-2 pl-0 border-b bg-grey-lighter">Value</th>
						</tr>
					</thead>
					<tbody class="">
						@foreach($product->specs as $spec)
						<tr>
							<td class="text-right p-4 border-b border-grey-light">{{ $spec->spec }} <hr class="inline-block h-px border-t w-2 h-0 m-0 ml-2 mb-1"></td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ $spec->value }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</tab>
			@endif
		</tabs>
	</div>
	@if(count($category->products)>1)
	<div class="font-bold text-lg mt-6 mb-2">Other products</div>
	<div class="flex flex-wrap -mx-2 text-base">
		@foreach($category->products as $catproduct)
		@if($catproduct->alias !== $product->alias)
		<div class="w-1/3 p-2">
			<div class="flex flex-wrap bg-white border shadow p-4">
				<div class="w-1/3">
					@if($catproduct->hasMedia('title'))
					<a href="/categories/{{ $catproduct->path }}/{{ $catproduct->alias }}" class="no-underline">
						<img src="{{ $catproduct->getFirstMediaUrl('title', 'product') }}" alt="Image of {{ $catproduct['name'] }}">
					</a>
					@endif
				</div>
				<div class="w-2/3">
					<div class="mx-4 flex flex-col h-full">
						<a href="/categories/{{ $catproduct->path }}/{{ $catproduct->alias }}" class="no-underline">
							<h3 class="mb-2">{{$catproduct->name}}</h3>
						</a>
						<div class="flex-1 text-max-primary font-bold mb-2">
							@money($catproduct->price,'ZAR')
						</div>
						<div class="">
							<a href="/categories/{{ $catproduct->path }}/{{ $catproduct->alias }}" class="no-underline">
								more&hellip;
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		@endforeach
	</div>
	@endif
</div>
@include('partial.footer')
@endsection
