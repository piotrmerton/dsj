
@extends('layout.base')

@section('title', __('Ranking'))

@section('content')

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">
			@include('components.standings.ranking', ['standings' => $ranking['standings'] ])
		</div>
	</div>


@endsection
