<li>
    <article>
        <header>
            <h2>{{ HTML::linkRoute('blog.post', $post->title, array($post->slug)) }}</h2>
        </header>
        <section>
            {{ Str::words($post->content) }}
        </section>
        <small>{{ HTML::linkRoute('blog.post', 'Read more', array($post->slug)) }}</small>
    </article>
</li>