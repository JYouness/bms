@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if($item->posts->count())
        <ul>
            @foreach($item->posts AS $post)
                @include('bms::blog._listed_post')
            @endforeach
        </ul>
    @else
        <p>There are no posts in this {{ $item_name }}.</p>
    @endif
@stop