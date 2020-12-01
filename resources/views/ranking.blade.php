
@extends('layout.base')

@section('title', $ranking['name'])

@section('banner_name', 'competition')
@section('banner_title', $ranking['name'])

@section('content')

	@include('components.banner.default')

	<div class="content__main content--jumper">

		<div class="viewport">

			@include('components.breadcrumbs')

			<div class="content__main content--ranking">
				<div class="viewport">
					@include('components.standings.ranking', ['standings' => $ranking['standings'] ])
				</div>
			</div>

		</div>

	</div>


@endsection
