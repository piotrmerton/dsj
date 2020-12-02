<section class="stats-component stats--tournament">

    <h2 class="stats__title text--center">
        {{ __('Statystyki') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a>
    </h2>

    <h3>{{ __('Zwycięstwa') }}</h3>
    @foreach($tournament['stats']['wins'] as $jumper)
        <dl class="stats__wins">
            <dt>
                <a href="{{ route('jumper', array( $jumper['name'], $tournament['id'], ) ) }}">
                    {{ $jumper['name'] }}
                </a> 
                {{ $jumper['country'] }}
            </dt>
            <dd>{{ $jumper['quantity'] }}</dd>	
        </dl>
    @endforeach

    <h3>{{ __('Podium') }}</h3>
    @foreach($tournament['stats']['top_three'] as $jumper)
        <dl class="stats__podiums">
            <dt>
                <a href="{{ route('jumper', array( $jumper['name'], $tournament['id'], ) ) }}">
                    {{ $jumper['name'] }}
                </a> 
                {{ $jumper['country'] }}
            </dt>
            <dd>{{ $jumper['quantity'] }}</dd>	
        </dl>
    @endforeach    
</section>