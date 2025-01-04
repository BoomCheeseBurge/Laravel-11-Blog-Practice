<h1 style="dislay=flex;">Laravel 11 Blog Practice 

<span>
    
![Project Logo](https://img.icons8.com/?size=35&id=umvn6ZS3pZAj&format=png&color=000000)

</span>
</h1>

## This project was built on Laravel ( 11.29.0 ) with TailwindCSS and AlpineJS.

The purpose of this project was to get familiar with Laravel 11 and explore its basic and advanced features. As with the common examples, a blog project, while simple, enables to cover a comprehensive understanding of the framework, encompassing both fundamental and complex features.

The project was developed using Laravel Herd (non-premium features) with SQLite file-based database, PHP 8.3, and Nginx webserver.


## Running the Application

The following command is used to run the project in development.

```
npm run dev
```

Laravel Valet was used to give a custom local host name. There is a Windows unofficial import of it, installable with Composer.

## Web-Application Sections

The project consist of the following sections.

* Homepage\
  |\
  |-------> Home (hero section; slider for exploring existing post categories; search posts)\
  |\
  |-------> About (for display)\
  |\
  |-------> Blog (lists all existing posts with search input and pagination)\
  |\
  |-------> Contact (form is there for display)
  
* Dashboard\
  |\
  |-------> Dashboard\
  |           &emsp;&emsp;&emsp;&emsp;&emsp; |\
  |           &emsp;&emsp;&emsp;&emsp;&emsp; |-------> Kanban (the kanban has not been implemented but for a landing page after a user has logged in)\
  |           &emsp;&emsp;&emsp;&emsp;&emsp; |\
  |           &emsp;&emsp;&emsp;&emsp;&emsp; |-------> Posts (user-managed posts)\
  |\
  |-------> Admin\
             &emsp;&emsp;&emsp;&emsp;&emsp; |\
             &emsp;&emsp;&emsp;&emsp;&emsp; |-------> All Posts (manage all user-created posts)\
             &emsp;&emsp;&emsp;&emsp;&emsp; |\
             &emsp;&emsp;&emsp;&emsp;&emsp; |-------> Categories (manage post categories)\
             &emsp;&emsp;&emsp;&emsp;&emsp; |\
             &emsp;&emsp;&emsp;&emsp;&emsp; |-------> Users (manage the application's users)\
* User Profile and Settings
  |\
  |-------> Profile (manage the authenticated user's profile)\
  |\
  |-------> Setting (manage the authenticated user's settings)\

## Roles

* Regular User
* Admin User

## Tables

All tables have common functionalities that would be seen in a typical table as follows.

* search table input.
* show/hide columns.
* show rows per page.
* resizable columns.
* pagination.

## Comment Section

The implemented comment section is not optimized which could have been done either by using the __nested-set/adjancency-list models__, or using the __Spatie library__. The comment section can also have child comments or replies. These replies are not limited (probably should have limited it to one reply for every comment).

## Like System

A like system is implemented for both the post and comment. There is a pivot table made for storing the likes of both a post and comment. Laravel provides an efficient method of storing these likes using Eloquent's polymorphic relationship.

## Livewire

Livewire was utilized ONLY in the admin's __all posts page__ and __profile edit__ to experiment and understand its features. Livewire itself is a full-stack framework for Laravel that brings the simplicity and reactivity (real-time updates) of frontend frameworks like React to the backend, enabling you to build dynamic and interactive user interfaces with plain PHP. Unfortunately, there remains an unresolved issue (due to the limitation of the author of this project) where event listeners are not consistently reattached to their respective elements after an action is performed.

## Testing

Feature tests were performed using __PHPUnit__. Simple yet sufficient tests are made from authentication, authorization, accessible page, see a particular text, ensure persisted or deleted database records, and stored uploaded files. These tests were already tested to run as individual classes and as a whole.

The point of testing in general is to be confident that the project functions properly. Consequently, testing is very helpful in ensuring that the codebase works as expected, and in identifying and fixing any code functionality that was overlooked during development.

## Future Improvements

- [ ] :x: Re-attach the event listeners in the admin's all posts page after re-rendering the Livewire page.
- [ ] :x: Re-factor the comment section to either use nested set model/adjacency list model, or implement Spatie's comment section library (and probably limit the number of comment reply to one).

## Third-Party Libraries

These libraries were installed (with composer and NPM) to provide additional functionalities either to simplify creating web components or expand existing features. The following lists out the third-party libraries used in this project.

__NPM__

* TailwindCSS ( 3.4.17 )
* Flowbite ( 2.5.2 )
* Flowbite Typography ( 1.0.4 )
* AlpineJS ( 3.14.3 )
* AlpineJS Persist ( 3.14.3 )
* SweetAlert ( 11.6.13 )
* Swiper ( 11.1.14 )

__Composer__

* Eloquent Sluggable ( 11.0 )
* Livewire ( 3.5 )
* Livewire Alert ( 3.0 )
* Laravel Phone ( 5.3 )
* Ziggy ( 2.3 )

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
