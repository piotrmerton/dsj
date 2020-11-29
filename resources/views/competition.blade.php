@extends('layout.base')

@section('title', $competition['name'])

@section('content')

	@include('components.breadcrumbs')

	<div class="content__main content--competition">
		<div class="viewport">

			<h1>Competition view {{ $competition['name'] }}</h1>
			<small>resources/views/competition</small>


			<div class="ui-tabs tabs--competition">
				<nav class="tabs__nav">
					<ul class="nav__list">
						<li class="list__item item--tab" data-tab-name="qualiifcations">
							<a class="do-toggle-tab" href="#">{{ __('Wyniki kwalifikacji')}}</a>
						</li>
						<li class="list__item item--tab tab--open" data-tab-name="final">
							<a class="do-toggle-tab" href="#">{{ __('Wyniki konkursu')}}</a>
						</li>
					</ul>
				</nav>
				<section class="tabs__contents">
					<ul class="tabs__list">
						<li class="list__item item--tab" data-tab-name="qualiifcations">
							<a class="tab__title do-toggle-tab">{{ __('Wyniki kwalifikacji')}}</a>
							<div class="tab__content">
								@include('components.standings.qualifications', ['competition' => $competition])
							</div>
						</li>
						<li class="list__item item--tab tab--open" data-tab-name="final">
							<a class="tab__title do-toggle-tab">{{ __('Wyniki konkursu')}}</a>
							<div class="tab__content">
								@include('components.standings.competition', ['competition' => $competition])
							</div>
						</li>						
					</ul>
				</section>
			</div><!-- /tabs -->

			@include('components.standings.tournament', ['data' => $tournament_standings])

		</div><!-- /viewport -->
	</div><!-- /content__main -->

@endsection