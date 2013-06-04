<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Formatter class/function name
    |--------------------------------------------------------------------------
    |
    | This should be set to the function you wish to call if you want to format
    | blog post content in a specific way (e.g. markdown processer), this will
    | be called when outputting blog content to the view.
    | Examples:
    |   'formatter' => array('\Class', 'function')
    |   'formatter' => array('function')
    |   array() // default, will do nothing
    | Note: Classes will be need to have a \ before the class name. Functions
    | are called STATICALLY. (Class::function)
    */
    'formatter' => array('Markdown', 'string'),
    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | This is the prefix used for displaying any content from the BMS pacakge
    | By default, posts, categories, tags etc will be found at:
    | blog/blog-title-here
    | blog/tag/tag-name
    | blog/category/category-name
    |
    | Leave blank for no prefix, e.g. 'prefix' => ''
    |
    */
    'prefix' => 'blog'

);