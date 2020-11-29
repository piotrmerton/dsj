@extends('layout.base')

@section('title', $data['name'])

@section('content')

	@include('components.banner.jumper')

	<div class="content__main content--jumper">

		<div class="viewport">

			@include('components.breadcrumbs')

			<h2>
				{{ __('Statystyki występów w') }} <a href="{{ $data['stats']['tournament']['url'] }}">{{ $data['stats']['tournament']['name'] }}</a>
			</h2>

			<dl class="stats-component stats--jumper">

				<dt>{{ __('Pozycje w poszczególnych konkursach') }}:</dt>
				<dd>
					@foreach( $data['stats']['competitions'] as $competition)
						<a href="{{ $competition['url'] }}" title="{{ $competition['name'] }}">{{ $competition['position'] }}</a>@if (!$loop->last), @endif
					@endforeach
				</dd>

				<dt>{{ __('Pozycje w klasyfikacji generalnej') }}:</dt>
				<dd>
					@foreach( $data['stats']['competitions'] as $competition)
						<a href="{{ route('standings', array( $data['stats']['tournament']['id'], $competition['id'])) }}">{{ $competition['position_tournament'] }}</a>@if (!$loop->last), @endif
					@endforeach
				</dd>	

				<dt>{{ __('Ile razy na podium') }}:</dt>
				<dd>{{ $data['stats']['top_three'] }}</dd>

				<dt>{{ __('Ilość zwycięstw') }}:</dt>
				<dd>{{ $data['stats']['wins'] }}</dd>	

				<dt>{{ __('Ilość razy w finałowej rundzie') }}:</dt>
				<dd>{{ $data['stats']['final_round'] }}</dd>	

			</dl>

		</div>

	</div>

@endsection