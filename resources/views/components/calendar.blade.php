<div class="calendar-component">
	<h2 class="calendar__title">{{ __('Kalendarz') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a></h2>

	<table class="calendar__table">
		@foreach($tournament['calendar'] as $competition)
			<tr @if (isset($competition['highlight']) )class="competition--highlight"@endif>
				<td>{{ $loop->iteration }}.</td>
				<td><img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$competition['country'].'.svg') }}" alt="{{ $competition['country'] }}"/></td>
				<td>
					<a href="{{ $competition['url'] }}">{{ $competition['name'] }}</a>
					@if (isset($competition['ranking']) )
						<a class="competition__ranking" href="{{ $competition['ranking']['url'] }}">{{ $competition['ranking']['name'] }}</a>
					@endif
				</td>
				<td>
					<ul class="calendar__podium">
						@foreach ($tournament['stats']['podiums'][$competition['id']] as $podium)
							<li><span class="podium__position">{{ $podium['real_position'] }}.</span><a href="{{ route('jumper', array($podium['name'], $tournament['id']) ) }}">{{ $podium['name'] }}</a></li>
						@endforeach
					</ul>
				</td>
				<td>{{ date('j.n.Y', $competition['date']) }}</td>
			</tr>
		@endforeach

	</table>
</div>