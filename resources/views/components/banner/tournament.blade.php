@extends('components.banner.default')

@section('banner_name', 'tournament')

@section('banner_content')

	<h1>
		<span class="label">{{ $tournament['name'] }}</span>
	</h1>

	<ul class="banner__meta">

		<li>{{ date('j.n.Y', $tournament['date_start']) }}</li>

	</ul>

@endsection