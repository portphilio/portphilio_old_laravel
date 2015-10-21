@extends('layouts.master')
@section('title', 'Login')
@section('main')
    <h1>Login</h1>
    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">
            <p>{{ session('info') }}</p>
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
    <form method="post" action="/login">
        {!! csrf_field() !!}
        <label for="login">Username/Email:</label>
        <input type="text" name="login" id="login">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <input type="submit" name="submit" id="submit">
    </form>
@endsection