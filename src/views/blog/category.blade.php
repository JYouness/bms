@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if($category->posts->count())
        <ul>
            @foreach($category->posts AS $post)
                @include('bms::blog._listed_post')
            @endforeach
        </ul>
    @else
        <p>There are no posts in this category.</p>
    @endif
@stop