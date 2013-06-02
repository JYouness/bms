@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    {{ Empower::update($baseurl, 'bms::posts', array('model' => $post)) }}

@stop