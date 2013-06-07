BMS (Blog Management System)
=======

**Please note this package is still in development, it may change a lot before mid-June, so please be patient.**

----

## What is BMS?

BMS is a blog management system that allows you to:

- Create, Edit, View and Delete blog posts
    - Each blog post belongs to a specific user
    - Each blog post can be "Draft" or "Published" to define it's visibility to the non-authors
    - Each blog post can have many categorys
    - Each blog post can have many tags
    - Each blog post can be part of a "series" - this is useful for things like Tutorials that are longer than one blog post etc
- Create, Edit, View and Delete Series
- Comes with default public views for:
    - viewing the most recent blog posts (blog.index)
    - viewing a singular blog post (blog.show)
    - viewing a list of blog categories (blog.categories)
    - viewing posts in a category (blog.category)
    - viewing posts in a tag (blog.tag)

All views can be swapped out for your own, detailed in Empower's README file [here](https://github.com/sorora/empower#customisable-views)

----

## Requirements

This package is created for Laravel 4. It pulls in the Aurp package for authentication and role based permissions.

## Installation

You can install this package via composer by adding the below to your `composer.json` file:

    "sorora/bms" : "dev-master"

Once you have installed the package via composer, see [here](https://github.com/sorora/empower#deployment-made-easy) to publish configuration/migrations for the packages in one command!

>**Note:** You also need to add `'Sorora\Bms\Providers\BmsServiceProvider'` to your `app/config/app.php` file in the `providers` array

----

## Configuration Options

### Customisable Views

To see how to customise views / layouts used within this package, please see the README for the Empower package [here](https://github.com/sorora/empower#customisable-views)

### Blog Base URL

By default the blog can be found at yoursite.com/blog - if you wish to change this you will need to edit the `config.php` file and set the `baseurl` to one of your choosing.

### Formatter

One core setting that often changes between blogs is how their content is stored. Some use textarea editors like TinyMCE or CKEditor, others use Markdown to enter their posts.

BMS allows you to accomodate for this with the `formatter` config option found in the `config.php` file. When outputting content, it will attempt to apply what is found in this configuration file to that content. For example:

By default it is empty, and thus does nothing to the content. Perfect for when you store HTML in your posts

    'formatter' => array()

To apply a function, as an example "strtolower" - which will make all the content lower case, do:

    'formatter' => array('strtolower')

To apply a function from a class, you can do:

    'formatter' => array('Class', 'function')

An example of Markdown usage:

    'formatter' => array('Markdown', 'string')

----

## Usage

To access the admin panel, please refer to Empower's README file.

----

## Important note

If for some reason you run the tests for this package, please note **it refreshes all migrations and re-migrates the packages migrations** to the database - so be warned, data may be lost!