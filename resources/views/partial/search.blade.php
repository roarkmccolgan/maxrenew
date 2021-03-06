<div class="bg-white py-4 relative z-40">
	<div class="container mx-auto flex flex-wrap items-center justify-between">
		<div class="mr-4 w-1/3 sm:w-1/5 p-1 order-0">
			<a href="/" class="no-underline" title="Homepage"><img class="w-full" src="/images/max-renew-logo.svg" alt=""></a>
		</div>
		<ais-index :search-store="searchStore" class="flex-grow order-1">
			<div class="flex items-center w-full p-1">
				<ais-search-box class="w-full relative flex items-center">
					<ais-input placeholder="Search product by name or reference..." :class-names="{ 'ais-input': 'shadow appearance-none border sm:rounded flex-grow py-2 px-3 mr-1 text-grey-darker' }">
					</ais-input>
					<ais-clear v-show="searchStore.query.length > 0" :class-names="{'ais-clear': 'flex-no-shrink p-2 px-3 rounded-full bg-max-secondary text-white border-max-secondary mx-1 hover:bg-max-secondary'}">
						<font-awesome-icon :icon="icons.times" />
					</ais-clear>
					<button class="flex-no-shrink p-2 px-3 rounded-full bg-max-secondary text-white border-max-secondary mx-1 hover:bg-max-secondary" type="submit">
						<font-awesome-icon :icon="icons.search" />
					</button>
					<ais-results v-show="searchStore.query.length > 0" class="absolute pin-x pin-t bg-white p-2 shadow" style="top: 102%">
						<template slot-scope="{ result }">
							<a :href="result.url" class="block font-bold no-underline text-max-primary p-2 hover:bg-grey-lighter">
								<ais-highlight :result="result" attribute-name="name"></ais-highlight>
								<p class="font-normal text-sm">
									<ais-highlight :result="result" attribute-name="description"></ais-highlight>
								</p>
							</a>
						</template>
					</ais-results>
				</ais-search-box>
			</div>
		</ais-index>
		@if (!Request::is('checkout'))
			@include('partial.cart')
		@endif
	</div>
</div>
<div v-show="searchStore.query.length > 0" class="z-0 absolute pin bg-max-primary opacity-75"></div>