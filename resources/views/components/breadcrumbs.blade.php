<ul class="breadcrumbs-component">

	<li>{{ __('Jesteś tutaj') }}:</li>

	@foreach ($breadcrumbs as $trail)

		@if ($trail['url'])
			<li><a href="{{ $trail['url'] }}">{{ $trail['title'] }}</a></li>
		@else
			<li><span>{{ $trail['title'] }}</span></li>
		@endif

	@endforeach

</ul>