<div class="standings-component standings--competition">

	<h2 class="standings__title">
		{{ __('Wyniki finałowe konkursu :competition', ['competition' => $competition['name']]) }}
	</h2>

	<table class="standings__table table--competition">
		<thead>
			<tr>
				<th class="position">{{ __('Pozycja') }}</th>
				<th class="bib">{{ __('Nr startowy') }}</th>
				<th class="name">{{ __('Zawodnik') }}</th>
				<th>{{ __('Kraj') }}</th>
				<th class="result">{{ __('I seria') }}</th>
				<th class="result">{{ __('II seria') }}</th>
				<th class="result">{{ __('Suma') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($competition['results'] as $row)
				<tr @if ($row['name'] == $leader)class="standings__leader"@endif>
					<td class="position">{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
					<td class="bib">{{ $row['bib'] }}</td>
					<td class="name"><a href="{{ url('/jumper/'.$row['name'].'/'.$competition['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td class="result">{{ $row['round1'] }}</td>
					<td class="result">{{ $row['round2'] ? $row['round2'] : '' }}</td>
					<td class="result">{{ $row['result'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>