@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    <ul>
        <li>Title: {{{ $series->title }}}</li>
    </ul>

@stop