@if ($softwares->count() > 0)
    <div class="scroller">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('core/base::tables.name') }}</th>
                <th>{{ trans('core/base::tables.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($softwares as $software)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>@if ($software->slug) <a href="{{ $software->url }}" target="_blank">{{ Str::limit($software->name, 100) }}</a> @else <strong>{{ Str::limit($software->name, 100) }}</strong> @endif</td>
                    <td>{{ date_from_database($software->created_at, 'd-m-Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($softwares->total() > $limit)
        <div class="widget_footer">
            @include('core/dashboard::partials.paginate', ['data' => $softwares, 'limit' => $limit])
        </div>
    @endif
@else
    @include('core/dashboard::partials.no-data', ['message' => trans('plugins/software::softwares.no_new_software_now')])
@endif
