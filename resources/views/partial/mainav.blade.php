<div class="bg-white border-t border-b border-grey-light">
	<div id="nav" class="container relative z-30 mx-auto flex -mt-px sm:px-0">
		@foreach($categories as $category)
		<div class="menu text-base flex border-l">
			<a href="/categories/{{ $category->alias }}" class="font-medium text-max-primary no-underline py-4 px-2">{{ $category->name }}</a>
			<div class="submenu absolute bg-white min-w-full p-2 pt-4 border border-grey-dark border-t-0">
				<div class="flex flex-wrap -mx-4">
					@if(!count($category->allSubCategories))
						<div class="px-4">
							<div class="text-sm uppercase text-grey pb-4 border-b mb-2">{{$category->name}}</div>
							@foreach($category['products'] as $product)
								<a href="/categories/{{ $category->alias }}/{{ $product->alias }}" class="flex items-center font-bold text-max-primary hover:text-max-secondary hover:bg-grey-lighter whitespace-no-wrap no-underline">
									@if($product->hasMedia('title'))
									<img src="{{ $product->getFirstMediaURL('title','micro') }}" alt="{{ $product->name }}" class="block mr-1 w-10 h-10">
									@endif
									{{ $product->name }}
								</a>
							@endforeach
						</div>
					@else
						@foreach($category->allSubCategories as $subCategory)
							<div class="px-4">
								<div class="text-sm uppercase text-grey pb-4 border-b mb-2">{{$subCategory->name}}</div>
								@if(!count($subCategory->allSubCategories))
									@foreach($subCategory['products'] as $product)
										<a href="/categories/{{ $category->alias }}/{{ $product->alias }}" class="flex items-center font-bold text-max-primary hover:text-max-secondary hover:bg-grey-lighter whitespace-no-wrap no-underline">
											@if($product->hasMedia('title'))
											<img src="{{ $product->getFirstMediaURL('title','micro') }}" alt="{{ $product->name }}" class="block mr-1 w-10 h-10">
											@endif
											{{ $product->name }}
										</a>
									@endforeach
								@else
									@foreach($subCategory->allSubCategories as $subSubCategory)
									<div class="flex flex-wrap -mx-4" title="{{ $subSubCategory->name }}">
										<div class="px-4">
											@foreach($subSubCategory['products'] as $product)
												<a href="/categories/{{ $category->alias }}/{{ $product->alias }}" class="flex items-center font-bold text-max-primary hover:text-max-secondary hover:bg-grey-lighter whitespace-no-wrap no-underline">
													@if($product->hasMedia('title'))
													<img src="{{ $product->getFirstMediaURL('title','micro') }}" alt="{{ $product->name }}" class="block mr-1 w-10 h-10">
													@endif
													{{ $product->name }}
												</a>
											@endforeach
										</div>
									</div>
									@endforeach
								@endif
							</div>
						@endforeach
						
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<div class="menuscreen z-20 hidden absolute pin bg-max-primary opacity-50">
		
	</div>
</div>
