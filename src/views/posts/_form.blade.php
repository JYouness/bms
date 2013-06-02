<p>{{ Form::label('series_id', 'Series') }}{{ Form::select('series_id', $series, $post->series_id) }}</p>

<p>{{ Form::label('title') }}{{ Form::text('title') }}</p>

<p>{{ Form::label('content') }}{{ Form::textarea('content') }}</p>

<p>{{ Form::label('categories') }}{{ Form::text('categories', $current_categories) }}</p>

<p>{{ Form::label('tags') }}{{ Form::text('tags', $current_tags) }}</p>

<p>{{ Form::label('published', 'Status') }}{{ Form::select('published', array('Draft', 'Published')) }}</p>
