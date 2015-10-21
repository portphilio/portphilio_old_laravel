@extends('layouts.master')
@section('title', 'Register')
@section('main')
	<h1>Register</h1>
	@if (count($errors) > 0)
		<div class="alert">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
    @if (session('warning'))
        <div class="alert alert-warning">
            <p>{{ session('warning') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            <p>{{ session('error') }}</p>
        </div>
    @endif
	<form method="post" action="/register">
		{!! csrf_field() !!}
		<label for="username">Username:</label>
		<input type="text" name="username" id="username">
		<label for="first_name">First Name:</label>
		<input type="text" name="first_name" id="first_name">
		<label for="last_name">Last Name:</label>
		<input type="text" name="last_name" id="last_name">
		<label for="email">Email:</label>
		<input type="email" name="email" id="email">
		<label for="email_confirmation">Confirm Email:</label>
		<input type="email" name="email_confirmation" id="email_confirmation">
		<label for="password">Password:</label>
		<input type="password" name="password" id="password">
		<label for="password_confirmation">Confirm Password:</label>
		<input type="password" name="password_confirmation" id="password_confirmation">
		<input type="submit" name="submit" id="submit">
	</form>

@endsection