<h1>Standings view</h1>
<small>resources/views/standings</small>

@include('components.standings.tournament', ['standings' => $data['standings'], 'tournament' => $data['tournament']])