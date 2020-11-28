@extends('layout.base')

@section('title', $tournament['name'])

@section('content')

	<h1>Tournament {{ $tournament['name'] }}</h1>

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">

			<h2>{{ __('Kalendarz') }}</h2>

			<ol class="competition__calendar">
				@foreach($tournament['calendar'] as $competition)

					<li>
						<a href="{{ url('/competition/'.$tournament['id'].'/'.$competition['id']) }}">{{ $competition['name'] }}</a>
					</li>

				@endforeach
			</ol>


			@include('components.standings.tournament', ['data' => $standings])
		</div>
	</div>


@endsection
