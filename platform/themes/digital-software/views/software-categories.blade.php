<div class="row">
    {!! Theme::partial('left-side',['categories' => $categories['categories']]) !!}
    <div class="col-12 col-md-8 col-lg-7 px-0">
        <div class="row">
            <div class="col-12">
                {!! Theme::partial('software-list',['softwares' => $softwares]) !!}
            </div>
        </div>
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
        {{--        <div class="wlt_sellspace sidebar270c"><a
                        href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270c">
                        <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                             style="width:270px; height:200px">
                            <div class="title">Advertise Here</div>
                            <div class="pricing">view pricing</div>
                        </div>
                    </a></div>
                <h4 class="mb-4 mt-3 title-bar"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Latest
                    News</h4>
                <div class="card mb-4">
                    <div class="card-body px-2 py-1">
                        <ul class="list-group list-group-flush top10 blog">
                            <li class="list-group-item px-0 py-3">

                                <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-8/">
                                    <div class="image">
                                        <img src="https://www.premiumpress.com/_demoimages/blog/blog8.jpg"
                                             alt=""
                                             data-src="https://www.premiumpress.com/_demoimages/blog/blog8.jpg"
                                             class="wlt_image img-fluid">
                                    </div>
                                    <div class="content">
                                        <h6>Example Blog Post</h6>
                                        <p class="recent-post-sm-meta mb-0"><i
                                                class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                                    </div>
                                </a>

                            </li>
                            <li class="list-group-item px-0 py-3">

                                <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-7/">
                                    <div class="image">
                                        <img src="https://www.premiumpress.com/_demoimages/blog/blog7.jpg"
                                             alt=""
                                             data-src="https://www.premiumpress.com/_demoimages/blog/blog7.jpg"
                                             class="wlt_image img-fluid">
                                    </div>
                                    <div class="content">
                                        <h6>Example Blog Post</h6>
                                        <p class="recent-post-sm-meta mb-0"><i
                                                class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                                    </div>
                                </a>

                            </li>
                            <li class="list-group-item px-0 py-3">

                                <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-6/">
                                    <div class="image">
                                        <img src="https://www.premiumpress.com/_demoimages/blog/blog6.jpg"
                                             alt=""
                                             data-src="https://www.premiumpress.com/_demoimages/blog/blog6.jpg"
                                             class="wlt_image img-fluid">
                                    </div>
                                    <div class="content">
                                        <h6>Example Blog Post</h6>
                                        <p class="recent-post-sm-meta mb-0"><i
                                                class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                                    </div>
                                </a>

                            </li>

                        </ul>
                    </div>
                </div>--}}

    </aside>
</div>
