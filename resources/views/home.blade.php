@extends('layouts.app')

@section('head')
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
{{-- Header --}}
<div class="bg-max-primary py-2 text-white text-sm font-bold relative z-20">
	<div class="container mx-auto flex justify-between px-2 sm:px-0">
		<div class="flex items-center">
			<div class="pr-4 mr-4 sm:border-r border-grey text-base">CALL NOW: <a class="no-underline text-teal-light" href="tel:+27119181800">+27 (011) 918 1800</a></div>
			<div class="hidden sm:block">Frequently Asked Questions</div>
		</div>
		<div class="hidden sm:block">
			<em>Free Delivery on orders over R2000</em>
		</div>
	</div>
</div>
<div class="bg-white py-4 relative z-20">
	<div class="container mx-auto flex items-center bg-white px-2 pt-2 sm:px-0">
		<div class="mr-4">
			<a href="/" class="no-underline" title="Homepage"><img class="w-48" src="/images/max-renew-logo.svg" alt=""></a>
		</div>
		<div class="flex items-center w-full">
			<input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker" placeholder="Search">
			<button class="flex-no-shrink p-2 px-3 rounded-full bg-teal text-white border-teal hover:bg-teal-dark"><font-awesome-icon :icon="icons.search" /></button>
		</div>
		<div class="ml-4">
			<button class="bg-teal text-white whitespace-no-wrap font-bold py-2 px-4 border-b-4 hover:border-b-2 hover:border-t-2 border-teal-dark hover:border-teal rounded">
				<font-awesome-icon :icon="icons.cart"></font-awesome-icon>
				<span class="hidden sm:inline-block text-sm">Your Cart</span>
			</button>
		</div>
	</div>
</div>

@include('partial.mainav')
<div class="container flex-1 mx-auto pb-8">
	<div class="mt-6 bg-white border shadow p-4">
		<img class="" src="/images/slidegeyser-100.jpg" alt="">
	</div>
	<div class="flex flex-wrap -mx-2 mt-6">
		<div class="w-1/3 p-2">
			<img class="" src="/images/special-100.jpg" alt="">
		</div>
		<div class="w-2/3 p-2">
			<div class="flex flex-wrap -m-2">
				@foreach($shop as $cat => $category)
				@if(isset($category['images']['tile']) && $category['images']['tile']['name']!='')
				<div class="w-1/3 p-2">
					<a href="{{'/categories/'.$cat.'/'}}" class="no-underline">
						<div class="bg-white border shadow p-2 hover:border-max-secondary">
							<img class="" src="/images/{{$category['images']['tile']['name']}}" alt="">
							<h4 class=" text-max-primary uppercase text-center pb-4 px-4 whitespace-no-wrap">{{$category['title']}}</h4>
						</div>
					</a>
				</div>
				@endif
				@endforeach
			</div>
		</div>
	</div>

	<div class="flex mt-6 mb-2 -mx-2">
		<div class="flex-1 bg-white border shadow mx-2">
		<img src="/images/free-delivery-100.jpg?id=1" alt="">
		</div>
		<div class="flex-1 bg-white border shadow mx-2">
			<img src="/images/installers-100.jpg" alt="">
		</div>
		<div class="flex-1 bg-white border shadow mx-2">
			<img src="/images/warranty-100.jpg" alt="">
		</div>
	</div>
</div>
@include('partial.footer')
@endsection
