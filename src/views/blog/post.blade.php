@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))

    <div>
        <small>
            <i>
                @if(!empty($updated_on))
                Last updated {{ $updated_on }}, originally
                @endif
                Posted {{ $posted_on }}
                @include('bms::blog._post_categories')
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
                            <i>{{{ $p->title }}}</i>
                        @else
                            {{ HTML::linkRoute('blog.post', $p->title, array($p->slug)) }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <article>
        {{ $post->content }}
    </article>

    @include('bms::blog._tags')
@stop