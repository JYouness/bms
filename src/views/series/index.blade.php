@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if ($series->count())

        <p>You can create a new {{ HTML::linkRoute($baseurl.'.create', 'series here') }}.</p>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Options</th>
            </tr>
            @foreach ($series as $seriesSingle)
                <tr>
                    <td>{{ $seriesSingle->id }}</td>
                    <td>{{ HTML::linkRoute($baseurl.'.show', $seriesSingle->title, array($seriesSingle->id)) }}</td>
                    <td>{{ HTML::linkRoute($baseurl.'.edit', 'Edit', array($seriesSingle->id)) }}{{ Empower::buttonDestroy($baseurl.'', $seriesSingle->id) }}</td>
                </tr>
            @endforeach
        </table>

    @else
        <p>There are no series to display, why not {{ HTML::linkRoute($baseurl.'.create', 'create') }} one?</p>
    @endif

@stop