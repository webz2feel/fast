@foreach($subcategories as $subcategory)
    <ul class="children">
        <li class="cat-item cat-item-3">
            <a href="{{$subcategory->slug}}">{{$subcategory->name}}</a>
        </li>
        @if(count($subcategory->children))
        {!! Theme::partial('categories.sub-category-list',['subcategories' => $subcategory->children]) !!}
    @endif
</ul>
@endforeach
