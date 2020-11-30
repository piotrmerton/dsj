<div class="rankings-component">
    <ul class="rankings__list">
        @foreach( $tournament['rankings'] as $ranking )
            <li class="list__item item--ranking">

                @if(in_array($tournament['latest_competition_id'], $ranking['competitions']))
                    <a href="{{ route('ranking', array($tournament['id'], $ranking['id'])) }}">{{ $ranking['name'] }}</a>
                @else
                    <span>{{ $ranking['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>