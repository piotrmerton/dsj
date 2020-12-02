<table class="stats__table">
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
            <td>{{ $jumper['quantity'] }}</td>
        </tr>
    @endforeach
</table>