<section class="banner-component banner--@yield('banner_name')">
    <div class="viewport">

        <div class="banner__content text--center">
            @section('banner_content')
                <h1>{{ __('Banner title') }}</h1>  
            @show
        </div>

        <figure class="banner__cover cover cover--overlay">
        	@section('banner__cover')

        	@show
        </figure>

    </div><!-- /viewport -->
</section>