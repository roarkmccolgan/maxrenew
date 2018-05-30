<div class="bg-max-primary py-2 text-white text-sm font-bold relative z-30">
	<div class="container mx-auto flex items-center justify-between px-2 sm:px-0">
		<div class="flex items-center">
			<div class="pr-4 mr-4 text-xs sm:border-r sm:text-base">CALL NOW: <a class="no-underline text-max-secondary" href="tel:+27119181800">+27 (011) 918 1800</a></div>
			<div class="hidden sm:block">Optimise how you use water and power in your home</div>
		</div>
		<div class="font-normal text-sm">
			@if($isLoggedIn)
			<div class="flex items-center">
				<div class="mr-2"><img class="rounded-full w-8 h-8" src="{{ $user['picture'] }}" /></div>
				<div><a class="no-underline text-white" href="{{ url("/logout") }}">logout</a></div>
			</div>
			@else
			<a class="no-underline text-white" href="{{ url("/login") }}">login</a>
			@endif
		</div>
	</div>
</div>