<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth0Controller extends Controller
{
	public function index()
	{
		$isLoggedIn = \Auth::check();
		return view('index')
		->with('isLoggedIn', $isLoggedIn);
	}

	public function login()
	{
		session(['afterlogin' => url()->previous()]);
		//dd(session('afterlogin'));
		return \App::make('auth0')->login(null, null, ['scope' => 'openid profile email'], 'code');
	}

	public function logout()
	{
		\Auth::logout();
		return  \Redirect::intended('/');
	}

	public function dump()
	{
		$isLoggedIn = \Auth::check();
		return view('dump')
		->with('isLoggedIn', $isLoggedIn)
		->with('user',\Auth::user()->getUserInfo())
		->with('accessToken',\Auth::user()->getAuthPassword());
	}
}
