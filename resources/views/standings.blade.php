
@extends('layout.base')

@section('title', __('Klasyfikacja'))

@section('content')

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">
			@include('components.standings.tournament', ['standings' => $data['standings'], 'tournament' => $data['tournament']])
		</div>
	</div>


@endsection
