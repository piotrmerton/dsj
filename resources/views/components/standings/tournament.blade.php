<table>

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
		@foreach ($data['standings'] as $row)
			<tr>
				<td>{{ $row['position'] != 0 ? $row['position'].'.' : '' }}</td>
				<td><a href="{{ url('/jumper/'.$row['name'].'/'.$data['tournament']['id']) }}">{{ $row['name'] }}</a></td>
				<td>{{ $row['country'] }}</td>
				<td>{{ $row['points'] }}</td>
				<td>{{ $row['difference'] }}</td>
			</tr>
		@endforeach
	</tbody>

</table>