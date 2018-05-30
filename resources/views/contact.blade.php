@extends('layouts.app')

@section('head')
<title>Max Renew - Contact Us</title>
@parent

@endsection
@section('body')
{{-- @includeWhen($pagetype == 'content', 'patial.mainmenu') --}}
<div class="container flex-1 mx-auto pb-8">
	<contact-component></contact-component>
</div>
@include('partial.footer')
@endsection
