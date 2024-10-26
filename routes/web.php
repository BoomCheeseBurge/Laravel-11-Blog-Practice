<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'title' => 'Home',
    ]);
});

Route::get('/about', function () {
    return view('about', [
        'title' => 'About',
        'name' => 'John Doe',
    ]);
});

Route::get('/posts', function () {
    return view('posts', [
        'title' => 'Blog',
        'posts' => [
            [
                'id' => 1,
                'slug' => 'post-title-1',
                'title' => 'Post Title 1',
                'author' => 'John Doe',
                'created_at' => 'January 1, 2024',
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quaerat consequatur laudantium beatae eius. Cumque, harum, deserunt perspiciatis quae laudantium inventore quod impedit maxime doloribus suscipit incidunt temporibus optio rerum?'
            ],
            [
                'id' => 2,
                'slug' => 'post-title-2',
                'title' => 'Post Title 2',
                'author' => 'John Doe',
                'created_at' => 'February 1, 2024',
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem repudiandae ab, animi vero fuga iure consequuntur dolore necessitatibus accusamus dolorum eligendi doloribus, harum est veritatis ipsam illo adipisci fugit sint.'
            ],
        ],
    ]);
});

Route::get('/posts/{slug}', function ($slug) {

    $posts = [
        [
            'id' => 1,
            'slug' => 'post-title-1',
            'title' => 'Post Title 1',
            'author' => 'John Doe',
            'created_at' => 'January 1, 2024',
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quaerat consequatur laudantium beatae eius. Cumque, harum, deserunt perspiciatis quae laudantium inventore quod impedit maxime doloribus suscipit incidunt temporibus optio rerum?'
        ],
        [
            'id' => 2,
            'slug' => 'post-title-2',
            'title' => 'Post Title 2',
            'author' => 'John Doe',
            'created_at' => 'February 1, 2024',
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem repudiandae ab, animi vero fuga iure consequuntur dolore necessitatibus accusamus dolorum eligendi doloribus, harum est veritatis ipsam illo adipisci fugit sint.'
        ],
    ];

    $post = Arr::first($posts, function ($post) use ($slug) {

        return $post['slug'] == $slug;
    });

    return view('post', [
        'title' => 'Single Post',
        'post' => $post,
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Contact',
    ]);
});
