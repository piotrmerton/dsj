<section class="standings-component standings--tournament">

	<h2 class="standings__title">
		{!! __('Klasyfikacja generalna 
			<a href=":url">:tournament</a> po :stage konkursie', [
			'url' => $data['tournament']['url'],
			'tournament' => $data['tournament']['name'],
			'stage' => $data['standings']['stage'],
		]) !!}
	</h2>

	<table class="standings__table table--tournament">
		<thead>
			<tr>
				<td>{{ __('Pozycja') }}</td>
				<td>{{ __('Zawodnik') }}</td>
				<td>{{ __('Kraj') }}</td>
				<td>{{ __('Punkty') }}</td>
				<td>{{ __('Strata') }}</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['standings']['results'] as $row)
				<tr>
					<td class="position">
						<span class="position__value">{{ $row['real_position'] }}.</span>
						<span class="position__trend trend--{{ $row['trend'] }}"></span>
					</td>
					<td><a href="{{ url('/jumper/'.$row['name'].'/'.$data['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td>{{ $row['points'] }}</td>
					<td>{{ $row['difference'] }}</td>
				</tr>
			@endforeach
		</tbody>

	</table>

</section>