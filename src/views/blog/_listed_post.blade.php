<li>
    <article>
        <header>
            <h2>{{ HTML::linkRoute('blog.post', $post->title, array($post->slug)) }}</h2>
        </header>
        <small>
            @if($post->updated_at > $post->created_at)
                Last updated {{ $post->getDateDiffForHumans('updated_at') }}, originally
            @endif
            Posted {{ $post->getDateDiffForHumans('created_at') }}
            @include('bms::blog._post_categories')
        </small>
        <section>
            {{ Str::words($post->content) }}
        </section>
        <small>
            {{ HTML::linkRoute('blog.post', 'Read more', array($post->slug)) }}<br />
            @include('bms::blog._tags')
        </small>
    </article>
</li>