@extends('layout.base')

@section('title', $competition['venue']['city'] . ' ' . $competition['venue']['hs'])

@section('content')

	<div class="content__main content--competition">
		<div class="viewport">

			<h1>Competition view {{ $competition['venue']['city'] }} {{ $competition['venue']['hs'] }}</h1>
			<small>resources/views/competition</small>


			<h2>{{ __('Wyniki konkursu') }}</h2>


			@include('components.standings.competition', ['competition' => $competition])

			@include('components.standings.tournament', ['data' => $tournament_standings])

		</div><!-- /viewport -->
	</div><!-- /content__main -->

@endsection