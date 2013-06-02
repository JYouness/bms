@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    {{ Empower::store($baseurl, 'bms::series') }}

@stop