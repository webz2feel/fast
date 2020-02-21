@if($softwares)
    @foreach($softwares as $software)
        <div class="software-item clearfix border mb-2">
            <div class="p-3">
                <div class="image">
                    <a href="{{route('public.software-detail', $software->slug)}}"
                       class="wlt_image_link"><img
                            src="{{ get_object_image($software->image) }}"
                            alt=""
                            class="wlt_image img-fluid"></a></div>
                <div class="content">
                    <h3 class="h5 font-weight-bold"><a
                            href="{{route('public.software-detail', $software->slug)}}">{{$software->name}}</a></h3>
                    <div class="text-dark small">
                        Added {{$software->updated_at->diffForHumans()}}

                    </div>
                    <span class="wlt_shortcode_excerpt">{{$software->description}}</span>
                    <div></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="bg-light pr-2 pt-2 mt-2 border-top">
                <div class="row">
                    <div class="col-md-12 col-sm-6 col-12">
                        <ul class="list-inline mt-1 mb-2 flex-list">
{{--                            <li class="list-inline-item"><i class="fa fa-download"></i> {{$software->downloads}}--}}
{{--                                Downloads--}}
{{--                            </li>--}}
{{--                            <li class="list-inline-item">--}}
{{--                                <i class="fa fa-comment" aria-hidden="true"></i> 0 Comments--}}
{{--                            </li>--}}
                            <li class="list-inline-item last"><i
                                    class="fa fa-bar-chart-o"></i> Viewed {{$software->views}} times
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
