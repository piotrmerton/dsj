@extends('layout.base')

@section('title', $tournament['name'])

@section('content')

	<h1>Tournament {{ $tournament['name'] }}</h1>

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">


			@include('components.calendar')

			@include('components.standings.tournament', ['data' => $standings])
		</div>
	</div>


@endsection
