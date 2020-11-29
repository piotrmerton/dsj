@extends('layout.base')

@section('title', $tournament['name'])

@section('content')

	@include('components.banner.tournament')

	<div class="content__main content--tournament">
		<div class="viewport">

			@include('components.breadcrumbs')

			<div class="content__main content--competition">
				<div class="viewport">

					@include('components.calendar')

					@include('components.standings.tournament', ['data' => $standings])
				</div>
			</div>
		</div>
	</div>




@endsection
