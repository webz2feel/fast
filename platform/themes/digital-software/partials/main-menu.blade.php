@foreach ($menu_nodes as $key => $row)
<li class="menu-item menu-item-type-post_type menu-item-object-page {{ $row->css_class }}">
    <a class="txt @if ($row->url == Request::url() || Str::contains(Request::url() . '?', $row->url)) active text-orange @endif" href="{{ $row->url }}" target="{{ $row->target }}">
        @if ($row->icon_font)<i class='{{ trim($row->icon_font) }}'></i> @endif{{ $row->title }}
        @if ($row->url == Request::url()) <span class="sr-only">(current)</span> @endif
    </a>
</li>
@endforeach
