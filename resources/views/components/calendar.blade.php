<div class="calendar-component">
	<h2 class="calendar__title">{{ __('Kalendarz') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a></h2>

	<table class="calendar__table">
		@foreach($tournament['calendar'] as $competition)
			<tr>
				<td>{{ $loop->iteration }}.</td>
				<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$competition['country'].'.svg') }}" alt="{{ $competition['country'] }}"/></td>
				<td><a href="{{ url('/competition/'.$tournament['id'].'/'.$competition['id']) }}">{{ $competition['name'] }}</a></td>
				<td>{{ date('j.n.Y', $competition['date']) }}</td>
			</tr>
		@endforeach

	</table>
</div>