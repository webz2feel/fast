<!--CONTENT-->
<div id="ismain-homes">
        @if ($projects->count())
            <div class="box_shadow" style="margin-top: 0;">
                <div class="container-fluid w90">
                <div class="projecthome">
                    <div class="row">
                        <div class="col-12">
                            <h2><a href="#">{{ __('Featured projects') }}</a></h2>
                            <p style="margin: 0; margin-bottom: 10px">{{ theme_option('home_project_description') }}</p>
                        </div>
                    </div>
                    <div class="row rowm10">
                        @foreach ($projects as $project)
                            <div class="col-6 col-sm-4  col-md-3 colm10">
                                <div class="item">
                                    <div class="blii">
                                        <div class="img"><img class="thumb" data-src="{{ get_object_image($project->image, 'small') }}" src="{{ get_object_image($project->image, 'small') }}" alt="{{ $project->name }}">
                                        </div>
                                        <a href="{{ $project->url }}" class="linkdetail"></a>
                                    </div>

                                    <div class="description">
                                        {{--<a href="#" class="text-orange heart" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('I care about this project!!!') }}"><i class="
                                    far
                                     fa-heart"></i></a>--}}
                                        <a href="{{ $project->url }}"><h5>{{ $project->name }}</h5>
                                            <p class="dia_chi"><i class="fas fa-map-marker-alt"></i> {{ $project->location }}</p>
                                            @if ($project->price_from || $project->price_to)
                                                <p class="bold500">{{ __('Price') }}: @if ($project->price_from) <span class="from">{{ __('From') }}</span> {{ format_price($project->price_from, $project->currency, false)  }} @endif @if ($project->price_to) - {{ format_price($project->price_to, $project->currency) }} @endif</p>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        @endif
        <div class="container-fluid w90">

        @if ($cities->count())
            <div class="padtop70">
                <div class="areahome">
                    <div class="row">
                        <div class="col-12">
                            <h2>{{ __('Projects by locations') }}</h2>
                            <p>{{ theme_option('home_description_for_properties_by_locations') }}</p>
                        </div>
                    </div>
                    <div style="position:relative;">
                        <div class="owl-carousel" id="cityslide">
                            @foreach($cities as $city)
                                <div class="item itemarea">
                                    <a href="{{ route('public.project-by-city', $city->slug) }}"><img src="{{ get_object_image($city->image, 'small') }}"
                                                     alt="{{ $city->name }}"><h4>{{ $city->name }}</h4>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <i class="am-next"><img src="{{ Theme::asset()->url('images/aleft.png') }}" alt="pre"></i>
                        <i class="am-prev"><img src="{{ Theme::asset()->url('images/aright.png') }}" alt="next"></i>
                    </div>
                </div>

            </div>
        @endif
    </div>

    @if (is_plugin_active('real-estate'))
        <div class="padtop70">
            <div class="box_shadow">

                <div class="container-fluid w90">
                    <div class="homehouse">
                        <div class="row">
                            <div class="col-12">
                                <h2>{{ __('Properties For Sale') }}</h2>
                                <p>{{ theme_option('home_description_for_properties_for_sale') }}</p>
                            </div>
                        </div>
                        <property-component type="sale" url="{{ route('public.ajax.properties') }}"></property-component>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid w90">
            <div class="homehouse padtop30">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('Properties For Rent') }}</h2>
                        <p>{{ theme_option('home_description_for_properties_for_rent') }}</p>
                    </div>
                </div>
                <property-component type="rent" url="{{ route('public.ajax.properties') }}"></property-component>
            </div>
        </div>
    @endif
    @if (is_plugin_active('blog'))
        <div class="box_shadow" style="margin-bottom: 0;padding-bottom: 80px;">
                <div class="container-fluid w90">
                <div class="discover">
                    <div class="row">
                        <div class="col-12">
                            <h2>{{ __('News') }}</h2>
                            <p>{{ theme_option('home_description_for_news') }}</p>
                            <br>
                            <div class="blog-container">
                                <news-component url="{{ route('public.ajax.posts') }}"></news-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<!--END CONTENT-->

