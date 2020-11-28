@extends('layout.base')

@section('title', $competition['name'])

@section('content')

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">

			<h1>Competition view {{ $competition['name'] }}</h1>
			<small>resources/views/competition</small>


			@include('components.standings.competition', ['competition' => $competition])

			@include('components.standings.qualifications', ['competition' => $competition])

			@include('components.standings.tournament', ['data' => $tournament_standings])

		</div><!-- /viewport -->
	</div><!-- /content__main -->

@endsection