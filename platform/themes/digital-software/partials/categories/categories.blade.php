<h4 class="title-bar"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Categories</h4>
<div class="header-1 mb-4">
    <div class="block-nav-categori">
        <div class="verticalmenu-content1">
            <div class=" wlt_shortcode_dcats clearfix d-none d-md-block d-lg-block">
                <ul class="mb-0 sf-menu sf-vertical">
                    @foreach($categories as $category)
                        <li class="cat-item cat-item-2 cat-parent">
                            <a
                                href="{{route('public.list-cat', $category->slug)}}"><i
                                    class="fa text-primary fa-archive"></i> {{$category->name}}
                            </a>
                            @if(count($category->children))
                                {!! Theme::partial('categories.sub-category-list',['subcategories' => $category->children]) !!}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
