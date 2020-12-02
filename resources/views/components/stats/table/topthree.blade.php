<table class="stats__table">

    <thead>
        <th>{{ __('')}}</th>
        <th>{{ __('Zawodnik')}}</th>
        <th>{{ __('I miejsce')}}</th>
        <th>{{ __('II miejsce')}}</th>
        <th>{{ __('III miejsce')}}</th>
        <th>{{ __('Razem')}}</th>
    </thead>

    <tbody>
        @foreach($stats as $jumper)
            <tr>
                <td>
                    <img class="ui-ico ico--flag" src="{{ asset('img/flags/'.$jumper['country'].'.svg') }}" alt="{{ $jumper['country'] }}"/>
                </td>        
                <td>
                    <a href="{{ route('jumper', array( $jumper['name'], $tournament['id'], ) ) }}">
                        {{ $jumper['name'] }}
                    </a>                
                </td>
                <td>{{ $jumper['1'] }}</td>
                <td>{{ $jumper['2'] }}</td>
                <td>{{ $jumper['3'] }}</td>
                <td>{{ $jumper['quantity'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>