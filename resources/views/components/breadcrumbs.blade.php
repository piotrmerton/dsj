<ul class="breadcrumbs-component">

	<li>{{ __('Jesteś tutaj') }}:</li>

	@foreach ($breadcrumbs as $trail)

		<li><a href="{{ $trail['url'] }}">{{ $trail['title'] }}</a></li>

	@endforeach

</ul>