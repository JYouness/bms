@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    {{ Empower::update($baseurl, 'bms::series', array('model' => $series)) }}

@stop