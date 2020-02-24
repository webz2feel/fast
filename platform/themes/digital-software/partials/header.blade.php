<header class="bg-primary border-bottom">

    <div class="container-full">

        <div class="ppt-header header-1 header-logo4 no-sticky py-lg-1 viewport-lg">
            <div class="container py-4">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="logo text-left pl-0">
                            @if (theme_option('logo'))
                                <a href="{{ route('public.single') }}">
                                    <img src="{{ get_image_url(theme_option('logo')) }}"
                                         class="img-fluid" height="40" alt="{{ theme_option('site_name') }}">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <form class="navbar-form navbar-right" id="top-form" role="search"
                              accept-charset="UTF-8"
                              action="{{ route('public.search') }}"
                              method="GET">
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ __('Search keyword...') }}" name="q">
                                    <button onclick="document.getElementById('top-form').submit()" id="tn-searchtop" class="js-btn-searchtop" type="button"><i class="fa fa-search text-secondary"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="burger-menu mt-5">
                <div class="line-menu line-half first-line"></div>
                <div class="line-menu"></div>
                <div class="line-menu line-half last-line"></div>
            </div>
        </div>
        <div class="container-full bg-extra bg-secondary">
            <nav class="header-nav1 bg-secondary mt-1">
                <div class="clearfix">
                    <div class="container">
                        <nav class="ppt-menu float-none separate-line submenu-scale text-left">
                            <nav class="ppt-menu float-none  text-left">
                                <ul id="menu-menu" class="">
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page"
                                        style="width:60px;border-left:0;"><a
                                            href="/"><i
                                                class="fa fa-home"></i></a></li>
                                    {!!
                                        Menu::renderMenuLocation('main-menu', [
                                            'options' => ['class' => 'navbar-nav justify-content-end'],
                                            'view'    => 'main-menu',
                                        ])
                                    !!}
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
    </div>

</header>
