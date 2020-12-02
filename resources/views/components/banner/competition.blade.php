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

@section('banner_nav')
	<nav class="banner__nav">

		@if ($prev_competition_url)
		<a class="nav__item item--prev" href="{{ $prev_competition_url }}">
			<img src="{{ asset('svg/next.svg') }}" />
		</a>
		@else
			<span class="nav__item item--prev item--disabled">
				<img src="{{ asset('svg/next.svg') }}" />
			</span>
		@endif

		@if ($next_competition_url)
		<a class="nav__item item--next" href="{{ $next_competition_url }}">
			<img src="{{ asset('svg/next.svg') }}" />
		</a>
		@else
			<span class="nav__item item--next item--disabled">
				<img src="{{ asset('svg/next.svg') }}" />
			</span>
		@endif
	</nav>
@endsection


{{-- @section('banner_cover')
	@if(file_exists('img/banner/'.$competition['venue']['city'].'.webp')) 
		<img src="{{ asset('img/banner/'.$competition['venue']['city'].'.webp') }}" />
	@endif
@endsection --}}