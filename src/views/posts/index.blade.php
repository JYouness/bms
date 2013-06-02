@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if ($posts->count())

        <p>You can create a new {{ HTML::linkRoute($baseurl.'.create', 'post here') }}.</p>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Options</th>
            </tr>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ HTML::linkRoute($baseurl.'.show', $post->title, array($post->id)) }}</td>
                    <td>{{ HTML::linkRoute($baseurl.'.edit', 'Edit', array($post->id)) }}{{ Empower::buttonDestroy($baseurl.'', $post->id) }}</td>
                </tr>
            @endforeach
        </table>

    @else
        <p>There are no posts to display, why not {{ HTML::linkRoute($baseurl.'.create', 'create') }} one?</p>
    @endif

@stop