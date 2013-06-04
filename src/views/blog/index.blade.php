@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if($posts->count())
        <ul>
            @foreach($posts AS $post)
                @include('bms::blog._listed_post')
            @endforeach
        </ul>
        {{ $posts->links() }}
    @else
        <p>There are no posts on this blog yet!</p>
    @endif
@stop