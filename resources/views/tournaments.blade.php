<h1>List of all Tournaments</h1>
<small>resources/views/tournaments</small>



<ul>

	@foreach($tournaments as $tournament)

		<li><a href="{{ url('/tournament/'.$tournament['id']) }}">{{ $tournament['name'] }}</a></li>

	@endforeach

</ul>