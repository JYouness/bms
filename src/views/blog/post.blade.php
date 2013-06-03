@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    <div>
        <small>
            <i>
                @if(!empty($updated_on))
                Last updated {{ $updated_on }}, originally
                @endif
                Posted {{ $posted_on }}
                @if($post->categories->count())
                    in
                    @for($i = 0; $i < $post->categories->count(); $i++)
                        {{ HTML::linkRoute('blog.category', $post->categories[$i]->name, array($post->categories[$i]->slug)) }}{{ ($i + 2 == $post->categories->count()) ? ' and' : (($i != $post->categories->count() - 1) ? ',' : null) }}
                    @endfor
                @endif
            </i>
        </small>
    </div>

    @if($series)
        <div>
            <b>Series</b>:
            <ul>
                @foreach($series->posts AS $p)
                    <li>
                        @if($p->id == $post->id)
                            <i>{{ $p->title }}</i>
                        @else
                            {{ HTML::linkRoute('blog.post', $p->title, array($p->slug)) }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        {{ $post->content }}
    </div>

    @if($post->tags->count())
    <div>
        <b>Tags</b>: {{ implode(', ', $post->tags->lists('name')) }}
    </div>
    @endif
@stop