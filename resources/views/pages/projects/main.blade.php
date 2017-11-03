@php
	$sec_menu_items = get_categories_menu( 'project', [ 'class' => 'half' ] );
@endphp

@section('nav-top-head')
	Projects
@endsection

@extends('layouts.app')