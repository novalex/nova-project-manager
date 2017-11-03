@php
	$sec_menu_items = get_categories_menu( 'snippet', [ 'class' => 'half' ] );
@endphp

@section('nav-top-head')
	Snippets
@endsection

@extends('layouts.app')