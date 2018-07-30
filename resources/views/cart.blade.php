@extends('layouts.app')

@section('head')
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
<div class="container flex-1 mx-auto pb-8">
	<div class="mt-6 p-4">
		<div class="flex flex-wrap my-6 text-base lg:-mx-2 lg:mb-0">
			<div class="w-full lg:px-2 lg:w-2/3">
				<h2 class="mb-2 font-light">Your Cart</h1>
				<table class="w-full text-sm text-left mb-2" cellpadding="0" cellspacing="0">
					<thead class="font-medium text-xs text-grey-dark uppercase border-grey">
						<tr>
							<th class="w-1/2 lg:w-1/5 p-2 border-b bg-grey-lighter">Product</th>
							<th class="p-2 pl-0 border-b bg-grey-lighter">Description</th>
							<th class="p-2 pl-0 border-b bg-grey-lighter">Qty</th>
							<th class="p-2 pl-0 border-b bg-grey-lighter">Installation</th>
							<th class="p-2 pl-0 border-b bg-grey-lighter">Price</th>
							<th class="p-2 pl-0 border-b bg-grey-lighter">Line Total</th>
						</tr>
					</thead>
					<tbody class="">
						@foreach($cart['items'] as $item)
						<tr>
							<td class="p-4 border-b border-grey-light">{{ $item['name'] }}</td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ $item['strapline'] }}</td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ $item['qty'] }}</td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ $item['installation'] }}</td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ money($item['price'],'ZAR') }}</td>
							<td class="font-semibold p-4 pl-0 border-b border-grey-light">{{ $item['display_price'] }}</td>
						</tr>
						@endforeach
						<tr class="bg-grey-lightest">
							<td class="p-4 border-t font-bold text-right" colspan="5">Total</td>
							<td class="p-4 border-t font-bold pl-0">{{ $cart['display_total'] }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="w-full lg:px-2 lg:w-1/3">
				<h2 class="mb-2 font-light">Checkout</h2>
				<form action="/checkout" method="POST">
				{{ csrf_field() }}
				<div class="bg-white px-4 border-t border-b lg:border lg:shadow">
					@if(!Auth::check())
					<div class="p-4 -mx-4 flex flex-col justify-center items-center text-white bg-indigo-light">
						<span class="text-white text-sm">Ordered with us before? </span>
						<a href="/login" class="inline-block mt-2 no-underline font-bold text-indigo bg-white hover:bg-indigo-lightest py-2 px-4 rounded">
							Login
						</a>
					</div>
					@endif
					<div class="p-4 -mx-4 flex items-center text-white border-t border-b border-white" :class="[wizard.currentStep == 1 ? 'bg-max-secondary' : 'bg-grey']">
						<h4 class="flex-1">Basic Info</h4>
						<a href="#" class="text-indigo-dark" @click.prevent="wizard.currentStep=1" v-if="wizard.complete">edit</a>
					</div>
					<transition name="accordian">
						<div class="overflow-hidden h-auto" v-show="wizard.currentStep==1" key="1">
							<div class="-mx-3 md:flex md:flex-wrap my-6">
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="fname">
										First name *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[1].errors.fname ? 'bg-red-lightest' : '']" id="fname" name="fname" type="text" placeholder="" @blur="validate(1,'fname')" v-model="wizard.basic.fname">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.fname">Please supply your first name.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="lname">
										Last name *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[1].errors.lname ? 'bg-red-lightest' : '']" id="lname" name="lname" type="text" placeholder="" @blur="validate(1,'lname')" v-model="wizard.basic.lname">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.lname">Please supply your last name.</p>
								</div>
								<div class="w-full px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="email">
										Email *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[1].errors.email ? 'bg-red-lightest' : '']" id="email" name="email" type="text" placeholder="" @blur="validate(1,'email')" v-model="wizard.basic.email">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.email">Please supply your email address.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="telephone">
										Telephone Number *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[1].errors.telephone ? 'bg-red-lightest' : '']" id="telephone" name="telephone" type="text" placeholder="" @blur="validate(1,'telephone')" v-model="wizard.basic.telephone">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.telephone">Please supply your Telephone number.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="mobile">
										Mobile Number
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" id="mobile" name="mobile" type="text" placeholder="" v-model="wizard.basic.mobile">
									
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="company">
										Comany name
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-3" id="company" name="company" type="text" placeholder="" v-model="wizard.basic.company">
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="vat">
										VAT Number
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary border border-grey-lighter rounded py-3 px-4" id="vat" name="vat" type="text" placeholder="" v-model="wizard.basic.vat">
								</div>
								@if(!Auth::check())
								<div class="w-full px-3 bg-indigo-lightest">
									<div class="-mx-3 md:flex md:flex-wrap my-2">
										<div class="w-full px-6 text-sm mb-2">Choose a password for easier checkout *</div>
										<div class="lg:w-1/2 px-6">
											<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="paswword">
												Password *
											</label>
											<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-3" :class="[wizard.steps[1].errors.password ? 'bg-red-lightest' : '']" id="password" name="company" type="password" v-model="wizard.basic.password" @blur="validate(1,'password')">
											<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.password">Password is required</p>
										</div>
										<div class="lg:w-1/2 px-6">
											<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="repeatpass">
												Repeat Password *
											</label>
											<input class="appearance-none block w-full bg-grey-lighter text-max-primary border border-grey-lighter rounded py-3 px-4" :class="[wizard.steps[1].errors.repeatpass ? 'bg-red-lightest' : '']" id="repeatpass" name="vat" type="password" v-model="wizard.basic.repeatpass" @blur="validate(1,'repeatpass')">
											<p class="text-red-light text-xs italic" v-show="wizard.steps[1].errors.repeatpass">Passwords must match</p>
										</div>
									</div>
								</div>
								@endif
							</div>
							<div class="-mx-3 mb-2">
								<div class=" px-3 mb-6">
									<button type="button" class="block w-full appearance-none font-bold text-white bg-grey-darker hover:bg-max-secondary py-2 px-4 rounded" @click="checkStep(1,$event)">
										<span class="inline-block">Next</span>
										<div class="inline-block w-6 mr-1">
											<transition name="component-bounce" mode="out-in">
												<font-awesome-icon :icon="busySaving ? icons.loading : icons.faAngleRight" :class="busySaving ? 'fa-spin' : ''" v-bind:key="1"></font-awesome-icon>
											</transition>
										</div>
									</button>
								</div>
							</div>
						</div>
					</transition>
					<div class="p-4 -mx-4 flex items-center text-white border-t border-b border-white" :class="[wizard.currentStep == 2 ? 'bg-max-secondary' : 'bg-grey']">
						<h4 class="flex-1">Delivery Info</h4>
						<a href="#" class="text-indigo-dark" @click.prevent="wizard.currentStep=2" v-if="wizard.complete">edit</a>
					</div>
					<transition name="accordian">
						<div class="overflow-hidden h-auto" v-show="wizard.currentStep==2" key="2">
							<div class="-mx-3 md:flex md:flex-wrap my-6">
								<div class="w-full px-3 bg-indigo-lightest">
									<div class="-mx-3 md:flex md:flex-wrap my-2 px-6">
										<label class="w-full text-sm mb-2" for="addlookup">
											Lookup your address
										</label>
										<input ref="autocomplete" 
									        placeholder="Search" 
									        class="px-6 py-3 mb-2 appearance-none block w-full bg-grey-lighter text-max-primary rounded"
									        onfocus="value = ''"
									        autocomplete="false" 
									        type="text" />
									</div>
								</div>
								<div class="lg:w-full px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address1">
										Address Line 1 *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[3].errors.delivery_address1 ? 'bg-red-lightest' : '']" id="delivery_address1" name="delivery[address1]" type="text" placeholder="" @blur="validate(3,'delivery_address1')" v-model="wizard.delivery.address1">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.delivery_address1">Please supply your Address Line 1.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address2">
										Address Line 2 *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[3].errors.delivery_address2 ? 'bg-red-lightest' : '']" id="delivery_address2" name="delivery[address2]" type="text" placeholder="" @blur="validate(3,'delivery_address2')" v-model="wizard.delivery.address2">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.delivery_address2">Please supply your Address Line 2.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address3">
										Address Line 3
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" id="delivery_address3" name="delivery[address3]" type="text" placeholder="" v-model="wizard.delivery.address3">
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="city">
										City *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[3].errors.delivery_city ? 'bg-red-lightest' : '']" id="delivery_city" name="delivery[city]" type="text" placeholder="" @blur="validate(3,'delivery_city')" v-model="wizard.delivery.city">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.delivery_city">Please supply your City.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="province">
										Province *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[3].errors.delivery_province ? 'bg-red-lightest' : '']" id="delivery_province" name="delivery[province]" type="text" placeholder="" @blur="validate(3,'delivery_province')" v-model="wizard.delivery.province">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.delivery_province">Please supply your Province.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="postal">
										Postal Code *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[3].errors.delivery_postal ? 'bg-red-lightest' : '']" id="delivery_postal" name="delivery[postal]" type="text" placeholder="" @blur="validate(3,'delivery_postal')" v-model="wizard.delivery.postal">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.delivery_postal">Please supply your Postal Code.</p>
								</div>
							</div>
							<div class="-mx-3 mb-2">
								<div class=" px-3 mb-6">
									<button type="button" class="block w-full appearance-none font-bold text-white bg-grey-darker hover:bg-max-secondary py-2 px-4 rounded" @click="checkStep(2,$event)">
										<span class="inline-block">Next</span>
										<div class="inline-block w-6 mr-1">
											<transition name="component-bounce" mode="out-in">
												<font-awesome-icon :icon="busySaving ? icons.loading : icons.faAngleRight" :class="busySaving ? 'fa-spin' : ''" v-bind:key="2"></font-awesome-icon>
											</transition>
										</div>
									</button>
								</div>
							</div>
						</div>
					</transition>
					<div class="p-4 -mx-4 flex items-center text-white border-t border-b border-white" :class="[wizard.currentStep == 3 ? 'bg-max-secondary' : 'bg-grey']">
						<h4 class="flex-1">Billing Info</h4>
						<a href="#" class="text-indigo-dark" @click.prevent="wizard.currentStep=3" v-if="wizard.complete">edit</a>
					</div>
					<transition name="accordian">
						<div class="overflow-hidden h-auto" v-show="wizard.currentStep==3" key="3">
							<div class="-mx-3 md:flex md:flex-wrap my-6">
								<div class="w-full px-3 mb-4 bg-indigo-lightest rounded">
									<div class="p-2">
										<label @keyup.space="$event.target.click()" @click="setSame">
											<input class="hidden" type="checkbox" id="same" name="same" value="Delivery is same as Billing" v-model="wizard.same">
											<div class="flex items-baseline">
												<div class="mr-2 text-2xl lg:text-xl">
													<font-awesome-icon :icon="icons.faSquare" v-if="!wizard.same"></font-awesome-icon>
													<font-awesome-icon :icon="icons.faCheckSquare" v-else></font-awesome-icon>
												</div>
												<div class="flex-grow">
													Delivery Address same as Billing Address?
												</div>
											</div>
										</label>
									</div>
								</div>
								<div class="lg:w-full px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address1">
										Address Line 1 *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[2].errors.billing_address1 ? 'bg-red-lightest' : '']" id="billing_address1" name="billing[address1]" type="text" placeholder="" @blur="validate(2,'billing_address1')" v-model="wizard.billing.address1">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.billing_address1">Please supply your Address Line 1.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address2">
										Address Line 2 *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[2].errors.billing_address2 ? 'bg-red-lightest' : '']" id="billing_address2" name="billing[address2]" type="text" placeholder="" @blur="validate(2,'billing_address2')" v-model="wizard.billing.address2">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.billing_address2">Please supply your Address Line 2.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="address3">
										Address Line 3
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" id="billing_address3" name="billing[address3]" type="text" placeholder="" v-model="wizard.billing.address3">
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="city">
										City *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[2].errors.billing_city ? 'bg-red-lightest' : '']" id="billing_city" name="billing[city]" type="text" placeholder="" @blur="validate(2,'billing_city')" v-model="wizard.billing.city">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.billing_city">Please supply your City.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="province">
										Province *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[2].errors.billing_province ? 'bg-red-lightest' : '']" id="billing_province" name="billing[province]" type="text" placeholder="" @blur="validate(2,'billing_province')" v-model="wizard.billing.province">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.billing_province">Please supply your Province.</p>
								</div>
								<div class="lg:w-1/2 px-3 mb-4">
									<label class="block tracking-wide text-max-primary text-xs font-bold mb-2" for="postal">
										Postal Code *
									</label>
									<input class="appearance-none block w-full bg-grey-lighter text-max-primary rounded py-3 px-4 mb-2" :class="[wizard.steps[2].errors.billing_postal ? 'bg-red-lightest' : '']" id="billing_postal" name="billing[postal]" type="text" placeholder="" @blur="validate(2,'billing_postal')" v-model="wizard.billing.postal">
									<p class="text-red-light text-xs italic" v-show="wizard.steps[2].errors.billing_postal">Please supply your Postal Code.</p>
								</div>
							</div>
							<div class="-mx-3 mb-2">
								<div class=" px-3 mb-6">
									<button type="button" class="block w-full appearance-none font-bold text-white bg-grey-darker hover:bg-max-secondary py-2 px-4 rounded" @click="checkStep(3,$event)">
										<span class="inline-block">Next</span>
										<div class="inline-block w-6 mr-1">
											<transition name="component-bounce" mode="out-in">
												<font-awesome-icon :icon="busySaving ? icons.loading : icons.faAngleRight" :class="busySaving ? 'fa-spin' : ''" v-bind:key="3"></font-awesome-icon>
											</transition>
										</div>
									</button>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<transition name="fade">
					<button type="submit" class="block w-full appearance-none border text-2xl font-bold text-white bg-max-secondary hover:bg-indigo-dark py-2 px-4 mt-4 rounded" v-if="wizard.complete">
						<span class="inline-block">Submit Order</span>
						<div class="inline-block w-6 mr-1">
							<font-awesome-icon :icon="icons.faCheck" class=""></font-awesome-icon>
						</div>
					</button>
				</transition>
				<form>
			</div>
		</div>
	</div>
</div>
@include('partial.footer')
@endsection
