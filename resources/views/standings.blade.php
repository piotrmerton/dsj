<h1>Standings view</h1>
<small>resources/views/standings</small>


<h2>{{ __('Klasyfikacja turnieju') }} <a href="{{ $data['tournament']['url'] }}">{{ $data['tournament']['name'] }}</a></h2>






@include('components.standings.tournament', ['standings' => $data['standings'], 'tournament' => $data['tournament']])