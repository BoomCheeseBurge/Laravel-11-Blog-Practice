<?php

namespace App\Models;

use Illuminate\Support\Arr;

class Post {

    public static function all(): array
    {

        return [
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
    }

    public static function find($slug): array
    {
        $post = Arr::first(static::all(), fn ($post) => $post['slug'] == $slug)  ?? abort(404);

        return $post;
    }
}

?>
