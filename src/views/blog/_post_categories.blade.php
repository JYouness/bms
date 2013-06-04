@if($post->categories->count())
    in
    @for($i = 0; $i < $post->categories->count(); $i++)
        {{ HTML::linkRoute('blog.category', $post->categories[$i]->name, array($post->categories[$i]->slug)) }}{{ ($i + 2 == $post->categories->count()) ? ' and' : (($i != $post->categories->count() - 1) ? ',' : null) }}
    @endfor
@endif