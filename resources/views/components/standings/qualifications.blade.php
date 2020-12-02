<div class="standings-component standings--qualifications">

	<h2 class="standings__title">
		{{ __('Wyniki kwalifikacji do konkursu :competition', ['competition' => $competition['name']]) }}
	</h2>

	<table class="standings__table table--qualifications">
		<thead>
			<tr>
				<th class="position">{{ __('Pozycja') }}</th>
				<th class="bib">{{ __('Nr startowy') }}</th>
				<th class="name">{{ __('Zawodnik') }}</th>
				<th>{{ __('Kraj') }}</th>
				<th class="result">{{ __('Odległość') }}</th>
				<th class="result">{{ __('Suma') }}</th>
				<th>{{ __('Kwalifikacja')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($competition['qualifications'] as $row)
				<tr @if ($row['name'] == $leader)class="standings__leader"@endif>
					<td class="position">{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
					<td class="bib">{{ $row['bib'] }}</td>
					<td class="name"><a href="{{ url('/jumper/'.$row['name'].'/'.$competition['tournament']['id']) }}">{{ $row['name'] }}</a></td>
					<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$row['country'].'.svg') }}" alt="{{ $row['country'] }}"/></td>
					<td class="result">{{ $row['round1'] }}</td>
					<td class="result">{{ $row['result'] }}</td>
					<td>{{ $row['qualified'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>