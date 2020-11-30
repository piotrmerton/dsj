@extends('layout.base')

@section('title', $tournament['name'])

@section('content')

	@include('components.banner.tournament')

	<div class="content__main content--tournament">
		<div class="viewport">

			@include('components.breadcrumbs')

			<div class="ui-tabs tabs--tournament">
				<nav class="tabs__nav">
					<ul class="nav__list">
						<li class="list__item item--tab" data-tab-name="calendar">
							<a class="do-toggle-tab" href="#">{{ __('Kalendarz')}}</a>
						</li>
						<li class="list__item item--tab tab--open" data-tab-name="standings">
							<a class="do-toggle-tab" href="#">{{ __('Klasyfikacja generalna')}}</a>
						</li>
						<li class="list__item item--tab" data-tab-name="rankings">
							<a class="do-toggle-tab" href="#">{{ __('Klasyfikacje')}}</a>
						</li>												
					</ul>
				</nav>
				<section class="tabs__contents">
					<ul class="tabs__list">
						<li class="list__item item--tab" data-tab-name="calendar">
							<a class="tab__title do-toggle-tab">{{ __('Kalendarz')}}</a>
							<div class="tab__content">
								@include('components.calendar')
							</div>
						</li>
						<li class="list__item item--tab tab--open" data-tab-name="standings">
							<a class="tab__title do-toggle-tab">{{ __('Wyniki konkursu')}}</a>
							<div class="tab__content">
								@include('components.standings.tournament', ['data' => $standings])
							</div>
						</li>

						<li class="list__item item--tab" data-tab-name="rankings">
							<a class="tab__title do-toggle-tab">{{ __('Klasyfikacje')}}</a>
							<div class="tab__content">
								
								<ul class="tournament__rankings">
									@foreach( $tournament['rankings'] as $ranking )
										<li class="list__item item--ranking">
											<a href="{{ route('ranking', array($tournament['id'], $ranking['id'])) }}">{{ $ranking['name'] }}</a>
										</li>
									@endforeach
								</ul>

							</div>
						</li>

					</ul>
				</section>
			</div><!-- /tabs -->
	
		</div>
	</div>

@endsection
