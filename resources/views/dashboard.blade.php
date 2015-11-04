@extends('layouts.master')
@section('title', 'Dashboard')
@section('page-header', 'Dashboard')
@section('main-content')
    <div class="row">
        <p>Hiya, <pre>{{ $u }}</pre>!</p>
    </div>
@endsection