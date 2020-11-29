<h1>{{ $data['name'] }}</h1>
<small>resources/views/jumper</small>


<h2>Statystyki - <a href="{{ $data['stats']['tournament']['url'] }}">{{ $data['stats']['tournament']['name'] }}</a></h2>

<dl>

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



</dl>

{{ (microtime(true) - LARAVEL_START) }}