@extends(Config::get('empower::layout'))

@section(Config::get('empower::section'))
    @if($categories->count())
        <ul>
            @foreach($categories AS $category)
                <li>{{ HTML::linkRoute('blog.category', $category->name, array($category->slug)) }}</li>
            @endforeach
        </ul>
        {{ $categories->links() }}
    @else
        <p>There are no categories to display.</p>
    @endif
@stop