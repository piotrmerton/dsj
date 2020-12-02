<div class="standings-component standings--tournament">

	<h2 class="standings__title">
		{!! __('Klasyfikacja generalna 
			<a href=":url">:tournament</a> po :stage konkursie', [
			'url' => $data['tournament']['url'],
			'tournament' => $data['tournament']['name'],
			'stage' => $data['standings']['stage'],
		]) !!}
	</h2>

	<div class="standings__ui">
		<select class="ui-standings do-toggle-standings">
			<option value="0">{{ __('Archiwum wyników') }}</option>
			@for ($i = 1; $i <= $data['tournament']['stats']['number_of_competitions']; $i++)
				<option value="{{ $i }}" data-url="{{ route('standings', array( $data['tournament']['id'], $i)) }}">
					{{ __('Klasyfikacja po :i konkursie', ['i' => $i]) }}
				</option>
			@endfor
		</select>
	</div>

	<table class="standings__table table--tournament">
		<thead>
			<tr>
				<td class="position">{{ __('Pozycja') }}</td>
				<td class="name">{{ __('Zawodnik') }}</td>
				<td>{{ __('Kraj') }}</td>
				<td class="result">{{ __('Punkty') }}</td>
				<td class="result">{{ __('Strata') }}</td>
				<td class="result">{{ __('Występów') }}</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['standings']['results'] as $row)
				<tr>
					<td class="position">
						<span class="position__value">{{ $row['real_position'] }}.</span>
						<span class="position__trend trend--{{ $row['trend'] }}"></span>
					</td>
					<td class="name"><a href="{{ url('/jumper/'.$row['name'].'/'.$data['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td class="result">{{ $row['points'] }}</td>
					<td class="result">{{ $row['difference'] }}</td>
					<td class="result">{{ $data['tournament']['stats']['final_round'][$row['name']]['quantity'] }}</td>
				</tr>
			@endforeach
		</tbody>

	</table>

</div>