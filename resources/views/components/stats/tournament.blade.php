<section class="stats-component stats--tournament">

    <h2 class="stats__title text--center">
        {{ __('Statystyki') }} <a href="{{ $tournament['url'] }}">{{ $tournament['name'] }}</a>
    </h2>


    <div class="ui-tabs tabs--stats">
        <nav class="tabs__nav">
            <ul class="nav__list">
                <li class="list__item item--tab tab--open" data-tab-name="wins">
                    <a class="do-toggle-tab" href="#">{{ __('Zwycięstwa')}}</a>
                </li>
                <li class="list__item item--tab" data-tab-name="top-three">
                    <a class="do-toggle-tab" href="#">{{ __('Miejsca na podium')}}</a>
                </li>                																		
            </ul>
        </nav>
        <section class="tabs__contents">
            <ul class="tabs__list">
                <li class="list__item item--tab tab--open" data-tab-name="wins">
                    <a class="tab__title do-toggle-tab">{{ __('Zwycięstwa')}}</a>
                    <div class="tab__content">
                        @include('components.stats.partials.table', ['stats' => $tournament['stats']['wins'] ])
                    </div>
                </li>
                <li class="list__item item--tab" data-tab-name="top-three">
                    <a class="tab__title do-toggle-tab">{{ __('Miejsca na podium')}}</a>
                    <div class="tab__content">
                        @include('components.stats.partials.table', ['stats' => $tournament['stats']['top_three'] ])
                    </div>
                </li>                
            </ul>
        </section>
    </div><!-- /tabs -->

</section>