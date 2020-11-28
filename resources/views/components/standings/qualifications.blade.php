<div class="standings-component standings--qualifications">

	<h2 class="standings__title">
		{{ __('Wyniki kwalifikacji do konkursu :competition', ['competition' => $competition['name']]) }}
	</h2>

	<table class="standings__table table--qualifications">
		<thead>
			<tr>
				<td>{{ __('Pozycja') }}</td>
				<td>{{ __('Nr startowy') }}</td>
				<td>{{ __('Zawodnik') }}</td>
				<td>{{ __('Kraj') }}</td>
				<td>{{ __('Odległość') }}</td>
				<td>{{ __('Suma') }}</td>
				<td>{{ __('Kwalifikacja')}}</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($competition['qualifications'] as $row)
				<tr>
					<td>{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
					<td>{{ $row['bib'] }}</td>
					<td><a href="{{ url('/jumper/'.$row['name'].'/'.$competition['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td>{{ $row['round1'] }}</td>
					<td>{{ $row['result'] }}</td>
					<td>{{ $row['qualified'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>