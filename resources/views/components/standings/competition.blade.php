<section class="standings-component standings--competition">

	<h2 class="standings__title">
		{{ __('Wyniki konkursu :competition', ['competition' => $competition['name']]) }}
	</h2>

	<table class="standings__table table--competition">
		<thead>
			<tr>
				<td>{{ __('Pozycja') }}</td>
				<td>{{ __('Nr startowy') }}</td>
				<td>{{ __('Zawodnik') }}</td>
				<td>{{ __('Kraj') }}</td>
				<td>{{ __('I seria') }}</td>
				<td>{{ __('II seria') }}</td>
				<td>{{ __('Suma') }}</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($competition['results'] as $row)
				<tr>
					<td>{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
					<td>{{ $row['bib'] }}</td>
					<td><a href="{{ url('/jumper/'.$row['name'].'/'.$competition['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td>{{ $row['country'] }}</td>
					<td>{{ $row['round1'] }}</td>
					<td>{{ $row['round2'] ? $row['round2'] : '' }}</td>
					<td>{{ $row['result'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</section>