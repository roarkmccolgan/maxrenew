@extends('layouts.app')

@section('head')
<title>Welcome to Max Renew</title>
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
<div class="container flex-1 mx-auto pb-8">
	<div class="mt-6">
		<carousel :autoplay="true" :per-page="1" :navigation-enabled="false">
			<slide>
				<a href="/categories/grey-water-systems"><img class="" src="/images/slidedidyouknow.jpg" alt=""></a>
			</slide>
			<slide>
				<a href="/categories/solar-water-heating"><img class="" src="/images/slidegeyser.jpg" alt=""></a>
			</slide>
			<slide>
				<img class="" src="/images/slideinstall.jpg" alt="">
			</slide>
		</carousel>
	</div>
	<div class="mt-4 p-4">
		<h2 class="mb-2">Welcome to MaxRenew</h2>
		<p class="mb-3">
			Water has never been this precious. And not just because of the current drought in parts of this country. Globally, we're quickly realising that we've been wasting natural resources, and that they are finite.
		</p>
		<p class="mb-3">
			It's time to get smarter about the way we use water and energy every day in our homes. Maxrenew's range of water recycling and optimisation products will help you conserve the water you buy from the municipality, reuse that water wherever possible, and capitalise on rainwater that falls on your property. Besides saving you money, our water recycling systems will also help you reduce your impact on the environment at the same time.
		</p>
		<p class="mb-3">
			When it comes to power in your home, depending on the municipal supply of electricity can be both expensive and unpredictable. Our range of solar products will help you reduce your dependence on Eskom, and save you money while you do it.
		</p>
	</div>
	<div class="flex flex-wrap sm:-mx-2 mt-4">
		<div class="order-1 mt-2 sm:mt-0 sm:p-2 sm:w-1/3 sm:order-0">
			<img class="" src="/images/special-100.jpg" alt="">
		</div>
		<div class="sm:w-2/3 sm:p-2 sm:order-1">
			<div class="flex flex-wrap sm:-m-4">
				@foreach($categories as $category)
				<div class="w-full sm:w-1/3 sm:p-2">
					<a href="{{'/categories/'.$category->alias.'/'}}" class="no-underline">
						<div class="flex items-center sm:flex-wrap bg-white border-t border-b sm:border sm:shadow p-2 hover:border-max-secondary">
							<div class="w-32 sm:w-full"><img class="" src="{{ $category->getFirstMediaUrl('title', 'thumb') }}" alt=""></div>
							<h4 class="text-max-primary uppercase sm:text-center sm:flex-1 sm:my-8">{{$category['name']}}</h4>
						</div>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="mt-2 p-4">
		<h2 class="uppercase mb-2">Why Use Us?</h2>
	</div>
	<div class="sm:flex sm:-m-4 mt-6 mb-2">
		<div class="p-2">
			<div class="sm:flex-1 bg-white border shadow">
				<img src="/images/free-delivery.jpg?id=1" alt="">
			</div>
		</div>
			
		<div class="p-2">
			<div class="sm:flex-1 bg-white border shadow">
				<img src="/images/installers.jpg" alt="">
			</div>
		</div>
			
		<div class="p-2">
			<div class="sm:flex-1 bg-white border shadow">
				<img src="/images/warranty.jpg" alt="">
			</div>
		</div>
			
	</div>
</div>
@include('partial.footer')
@endsection
