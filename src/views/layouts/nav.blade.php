@if(Aurp::can('create_posts'))
    <li><b>Blog</b></li>
    <li>{{ HTML::linkRoute(Config::get('empower::baseurl').'.posts.create', 'Create Blog Post') }}</li>
@endif
@if(Aurp::can('show_posts'))
    <li>{{ HTML::linkRoute(Config::get('empower::baseurl').'.posts.index', 'View Blog Posts') }}</li>
@endif
@if(Aurp::can('create_series'))
    <li>{{ HTML::linkRoute(Config::get('empower::baseurl').'.series.create', 'Create Blog Series') }}</li>
@endif
@if(Aurp::can('show_series'))
    <li>{{ HTML::linkRoute(Config::get('empower::baseurl').'.series.index', 'View Blog Series') }}</li>
@endif