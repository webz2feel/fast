<h4 class="title-bar"><i class="fa fa-cloud-download" aria-hidden="true"></i> Latest Downloads</h4>
<div class="card mb-4 py-0">
    <div class="card-body py-1">
        <ul class="list-group list-group-flush top10 popular">
            @foreach($latestDownloads['latestDownloads'] as $download)
                <li class="list-group-item px-0 py-2">
                <div class="image">
                    <img src="{{get_object_image($download->image)}}"
                         alt=""
                         class="wlt_image img-fluid"></div>
                <div class="details mt-1">
                    <a href="{{route('public.software-detail', $download->slug)}}"
                       class="font-weight-bold">{{$download->name}}</a>
                </div>
                <p class="mb-0 mt-1 small">
                    {{$download->views}} views /

                    {{$download->downloads}} downloads
                </p>
            </li>
             @endforeach
        </ul>
    </div>
</div>
