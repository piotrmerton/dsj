<section class="breadcrumbs-component">
	<ul class="breadcrumbs__list">

		<li class="list__item item--start">{{ __('Jesteś tutaj') }}:</li>

		@foreach ($breadcrumbs as $trail)

			@if ($trail['url'])
				<li class="list__item"><a href="{{ $trail['url'] }}">{{ $trail['title'] }}</a></li>
			@else
				<li class="list__item"><span>{{ $trail['title'] }}</span></li>
			@endif

		@endforeach

	</ul>
</section>