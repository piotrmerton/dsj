@extends('components.banner.default')

@section('banner_name', 'competition')

@section('banner_content')

	<h1>
		<span class="label">{{ $competition['name'] }}</span>
		<img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$competition['country'].'.svg') }}" alt="{{ $competition['country'] }}"/>
	</h1>

	<ul class="banner__meta">

		<li><a href="{{ $tournament_standings['tournament']['url'] }}">{{ $tournament_standings['tournament']['name'] }}</a></li>
		<li>{{ date('j.n.Y', $competition['date']) }}</li>

	</ul>

@endsection


@section('banner__cover')
	@if(file_exists('img/banner/'.$competition['venue']['city'].'.webp')) 
		<img src="{{ asset('img/banner/'.$competition['venue']['city'].'.webp') }}" />
	@endif
@endsection