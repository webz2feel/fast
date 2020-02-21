<div class="row">
    {!! Theme::partial('left-side',['categories' => $categories['categories']]) !!}
    <div class="col-12 col-md-8 col-lg-7 px-0">
        <div class="border" style="background: #fff;">
            <div class="row">
                <div class="col-md-12  px-lg-4">
                    <div class="row">
                        <div class="col-md-6 text-center product-img-box mt-4">
                            <img src="{{get_object_image($software->image)}}"
                                 class="img-fluid" alt=""></div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush"
                                style="font-size:14px; background:none;">
                                <li class="list-group-item">
                                    <h1 class="h4 mb-4 mt-3">{{$software->name}}</h1>
                                    <p><span class="wlt_shortcode_excerpt"></span></p>
                                </li>
{{--                                <li class="list-group-item"><i class="fa fa-download"></i> {{$software->downloads}}--}}
{{--                                    Downloads--}}
{{--                                </li>--}}
                                <li class="list-group-item">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i> Listed under
                                    <span class="wlt_shortcode_category "><a
                                            href="http://so9.wlthemes.com/listing-category/desktop/">
                                            @foreach($software->categories as $cat)
                                                {{rtrim($cat->name.',',',')}}
                                            @endforeach</a></span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-bar-chart-o"></i> Viewed
                                    {{$software->views}} times
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-light border my-4 p-3">
                        <div class="row">
                            <div class="col-4">
                                <div class="btn-group btn-block">
                                    <a class="btn btn-lg btn-primary disabled"><i
                                            class="fa fa-download text-white"
                                            style="width:16px; height:20px"></i></a>
                                    <a class="btn btn-lg   btn-block btn-primary "
                                       href="{{$software->download_link_32}}" id="single_addcart_btn"> Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tab-content pb-5">
                        <div class="tab-pane fade active show" id="desc"
                             aria-labelledby="home-tab">
                            <div class="bg-light py-5 text-muted mt-2 typography p-3">
                                <h6 class="font-weight-bold text-uppercase mb-4">Description</h6>
                                {!! $software->content  !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mb-4 mt-4 title-bar">Related Software</h4>
        {!! Theme::partial('software-list',['softwares' => $softwares]) !!}
    </div>
    <aside class="sidebar-home col-12 col-md-4 col-lg-3">
        {!! Theme::partial('top-downloads',['topDownloads' => $topDownloads]) !!}

        <div class="wlt_sellspace sidebar270a"><a
                href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270a">
                <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                     style="width:270px; height:200px">
                    <div class="title">Advertise Here</div>
                    <div class="pricing">view pricing</div>
                </div>
            </a></div>
        {!! Theme::partial('latest-downloads',['latestDownloads' => $latestDownloads]) !!}

        <div class="wlt_sellspace sidebar270b"><a
                href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270b">
                <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                     style="width:270px; height:200px">
                    <div class="title">Advertise Here</div>
                    <div class="pricing">view pricing</div>
                </div>
            </a></div>
    </aside>
</div>
