<h1>Tournament {{ $tournament['name'] }}</h1>
<small>resources/views/tournament</small>


<h1>Calendar</h1>
<ol>

	@foreach($tournament['calendar'] as $competition)

		<li>
			<a href="{{ url('/competition/'.$tournament['id'].'/'.$competition['id']) }}">{{ $competition['venue']['city'] }}</a>
		</li>

	@endforeach

</ol>


<h1>Standings</h1>

@include('components.standings.tournament', ['data' => $standings])

