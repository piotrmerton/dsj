@extends('components.banner.default')

@section('banner_name', 'jumper')

@section('banner_content')

	<h1>
		<span class="label">{{ $data['name'] }}</span>
		<img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$data['country'].'.svg') }}" alt="{{ $data['country'] }}"/>		
	</h1>

	<ul class="banner__meta">

		<li>{{ __('Statystyki w') }} <a href="{{ $data['stats']['tournament']['url'] }}">{{ $data['stats']['tournament']['name'] }}</a></li>
		<li>{{ date('j.n.Y', $data['stats']['tournament']['date_start']) }}</li>

	</ul>

@endsection