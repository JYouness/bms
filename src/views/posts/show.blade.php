@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    <ul>
        <li>Title: {{{ $post->title }}}</li>
    </ul>

@stop