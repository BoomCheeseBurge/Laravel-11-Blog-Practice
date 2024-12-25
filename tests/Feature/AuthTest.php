<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    private User $adminUser;
    private User $user;

    public function setUp():void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create();
    }

    public function test_login_redirects_user_to_dashboard_kanban(): void
    {
        User::create([
            'username' => 'johntothedoe',
            'fullname' => 'John Doe',
            'email' => 'doe@gmail.com',
            'password' => Hash::make('P@ssW0rd123'),
        ]);

        $response = $this->post(route('login.authenticate'), [

            'email' => 'doe@gmail.com',
            'password' => 'P@ssW0rd123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard.kanban'));
    }

    public function test_incorrect_email_throws_anonymous_error(): void
    {
        User::create([
            'username' => 'johntothedoe',
            'fullname' => 'John Doe',
            'email' => 'doe@gmail.com',
            'password' => Hash::make('P@ssW0rd123'),
        ]);

        $response = $this->post(route('login.authenticate'), [

            'email' => 'john@gmail.com',
            'password' => 'P@ssW0rd123',
        ]);

        $response->assertSessionHas('failed');
    }

    public function test_incorrect_password_throws_anonymous_error(): void
    {
        User::create([
            'username' => 'johntothedoe',
            'fullname' => 'John Doe',
            'email' => 'doe@gmail.com',
            'password' => Hash::make('P@ssW0rd123'),
        ]);

        $response = $this->post(route('login.authenticate'), [

            'email' => 'doe@gmail.com',
            'password' => 'password',
        ]);

        $response->assertSessionHas('failed');
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard.kanban'));

        $this->assertGuest();
        $response->assertRedirect(route('login.index'));
    }

    public function test_admin_user_can_see_admin_posts_link(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('posts.index'));

        $response->assertSee('All Posts');
    }

    public function test_non_admin_user_cannot_see_admin_posts_link(): void
    {
        $response = $this->actingAs($this->user)->get(route('posts.index'));

        $response->assertDontSee('All Posts');
    }

    public function test_admin_user_can_view_admin_posts(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.posts.index'));

        $response->assertStatus(200);
    }
    public function test_admin_user_can_view_admin_categories(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('categories.index'));

        $response->assertStatus(200);
    }
    public function test_admin_user_can_view_admin_users(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_non_admin_user_cannot_view_admin_posts(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.posts.index'));

        $response->assertStatus(403);
    }
    public function test_non_admin_user_cannot_view_admin_categories(): void
    {
        $response = $this->actingAs($this->user)->get(route('categories.index'));

        $response->assertStatus(403);
    }
    public function test_non_admin_user_cannot_view_admin_users(): void
    {
        $response = $this->actingAs($this->user)->get(route('users.index'));

        $response->assertStatus(403);
    }

    public function test_non_authenticated_user_cannot_view_admin_posts(): void
    {
        $response = $this->get(route('admin.posts.index'));

        $response->assertRedirect(route('login.index'));
    }
    public function test_non_authenticated_user_cannot_view_admin_categories(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertRedirect(route('login.index'));
    }
    public function test_non_authenticated_user_cannot_view_admin_users(): void
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login.index'));
    }

    public function test_authenticated_user_can_view_user_profile(): void
    {
        $response = $this->actingAs($this->user)->get(route('user.profile', ['user' => $this->user->username]));

        $response->assertStatus(200);
    }
    public function test_authenticated_user_can_view_user_account(): void
    {
        $response = $this->actingAs($this->user)->get(route('user.account', ['user' => $this->user->username]));

        $response->assertStatus(200);
    }

    public function test_non_authenticated_user_cannot_view_user_profile(): void
    {
        $response = $this->get(route('user.profile', ['user' => $this->user->username]));

        $response->assertRedirect(route('login.index'));
    }
    public function test_non_authenticated_user_cannot_view_user_account(): void
    {
        $response = $this->get(route('user.account', ['user' => $this->user->username]));

        $response->assertRedirect(route('login.index'));
    }
}
