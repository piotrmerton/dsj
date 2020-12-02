<section class="stats-component stats--tournament">

    <h2 class="stats__title text--center">
        {{ __('Statystyki') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a>
    </h2>

    <h3>{{ __('Zwycięstwa') }}</h3>

    @foreach($tournament['stats']['wins'] as $winner)
        <dl class="stats__wins">
            <dt>{{ $winner['name'] }} {{ $winner['country'] }}</dt>
            <dd>{{ $winner['quantity'] }}</dd>	
        </dl>
    @endforeach
</section>