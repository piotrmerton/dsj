<section class="banner-component banner--@yield('banner_name')">
    <div class="viewport">

        <div class="banner__content text--center">
            @section('banner_content')

                <h1>@yield('banner_title')</h1>  
                
            @show
        </div>

        <figure class="banner_cover cover cover--overlay">
        	@section('banner_cover')

        	@show
        </figure>

    </div><!-- /viewport -->

    @section('banner_nav')

    @show

</section>