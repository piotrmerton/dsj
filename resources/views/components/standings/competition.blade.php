<div class="standings-component standings--competition">

	<h2 class="standings__title">
		{{ __('Wyniki finałowe konkursu :competition', ['competition' => $competition['name']]) }}
	</h2>

	<table class="standings__table table--competition">
		<thead>
			<tr>
				<td class="position">{{ __('Pozycja') }}</td>
				<td class="bib">{{ __('Nr startowy') }}</td>
				<td class="name">{{ __('Zawodnik') }}</td>
				<td>{{ __('Kraj') }}</td>
				<td class="result">{{ __('I seria') }}</td>
				<td class="result">{{ __('II seria') }}</td>
				<td class="result">{{ __('Suma') }}</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($competition['results'] as $row)
				<tr>
					<td class="position">{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
					<td class="bib">{{ $row['bib'] }}</td>
					<td class="name"><a href="{{ url('/jumper/'.$row['name'].'/'.$competition['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td class="result">{{ $row['round1'] }}</td>
					<td class="result">{{ $row['round2'] ? $row['round2'] : '' }}</td>
					<td class="result">{{ $row['result'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>