@if($post->tags->count())
    <div>
        <b>Tags</b>:
        @for($i = 0; $i < $post->tags->count(); $i++)
            {{ HTML::linkRoute('blog.tag', $post->tags[$i]->name, array($post->tags[$i]->slug)) }}{{ (($i != $post->tags->count() - 1) ? ',' : null) }}
        @endfor
    </div>
@endif