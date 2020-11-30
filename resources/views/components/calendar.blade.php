<div class="calendar-component">
	<h2 class="calendar__title">{{ __('Kalendarz') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a></h2>

	<table class="calendar__table">
		@foreach($tournament['calendar'] as $competition)
			<tr @if (isset($competition['highlight']) )class="competition--highlight"@endif>
				<td>{{ $loop->iteration }}.</td>
				<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$competition['country'].'.svg') }}" alt="{{ $competition['country'] }}"/></td>
				<td>
					<a href="{{ url('/competition/'.$tournament['id'].'/'.$competition['id']) }}">{{ $competition['name'] }}</a>
					@if (isset($competition['ranking']) )
						<span class="competition__ranking">{{ $competition['ranking'] }}</span>
					@endif
				</td>
				<td>{{ date('j.n.Y', $competition['date']) }}</td>
			</tr>
		@endforeach

	</table>
</div>