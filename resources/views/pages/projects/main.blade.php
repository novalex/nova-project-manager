@php
	$sec_menu_items = App\Project::get()->each( function( $item, $key ) {
		if ( empty( $item->slug ) ) {
			$item->url = 'projects/' . $key;
		} else {
			$item->url = 'projects/' . $item->slug;
		}

		$item->desc = $item->type;
	});
@endphp

@section('nav-top-head')
	Projects
@endsection

@extends('layouts.app')