<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;

class AdminUserTest extends TestCase
{
    private User $user;
    private User $adminUser;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }
    
    public function test_non_admin_users_cannot_access_admin_user_page(): void
    {
        $this->actingAs($this->user)->get(route('users.index'))->assertStatus(403);
    }

    public function test_admin_users_can_access_admin_user_page(): void
    {
        $this->actingAs($this->adminUser)->get(route('users.index'))->assertStatus(200);
    }

    public function test_non_admin_users_cannot_store_users(): void
    {
        Storage::fake('profile');
        Storage::fake('cover');

        $profile = UploadedFile::fake()->image('profile.jpg')->size(800);
        $cover = UploadedFile::fake()->image('cover.jpg')->size(800);
        
        $newUser = [
            'fullname' => 'John Doe',
            'username' => 'johntothedoe',
            'email' => 'doe@gmail.com',
            'password' => 'P@ssW0rd123',
            'confirmPassword' => 'P@ssW0rd123',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus a ipsum sollicitudin, maximus dui et, congue magna. Etiam sed pretium ante, a tristique ligula. Proin.',
            'profile_pic' => $profile,
            'profile_cover' => $cover,
            'is_admin' => false,
        ];

        $this->actingAs($this->user)
            ->post(route('users.store'), $newUser)
            ->assertStatus(403);
    }

    public function test_admin_users_store_user_successful(): void
    {
        Storage::fake('profile');
        Storage::fake('cover');

        $profile = UploadedFile::fake()->image('profile.jpg')->size(800);
        $cover = UploadedFile::fake()->image('cover.jpg')->size(800);
        
        $newUser = [
            'fullname' => 'John Doe',
            'username' => 'johntothedoe',
            'email' => 'doe@gmail.com',
            'password' => 'P@ssW0rd123',
            'confirmPassword' => 'P@ssW0rd123',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus a ipsum sollicitudin, maximus dui et, congue magna. Etiam sed pretium ante, a tristique ligula. Proin.',
            'profile_pic' => $profile,
            'profile_cover' => $cover,
            'is_admin' => false,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.store'), $newUser);

        $response->assertSessionHas('success');

        $this->assertEquals($newUser['email'], User::get()->last()['email']);
        Storage::disk('profile')->assertExists($profile->hashName());
        Storage::disk('cover')->assertExists($cover->hashName());
    }

    public function test_create_user_redirects_and_returns_validation_errors()
    {
        Storage::fake('profile');
        Storage::fake('cover');

        $profile = UploadedFile::fake()->image('profile.jpg')->size(2000);
        $cover = UploadedFile::fake()->image('cover.jpg')->size(3000);
        
        $newUser = [
            'fullname' => '7im0thy F0rr3st',
            'username' => 'TheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImagined',
            'email' => 'doeatfake.com',
            'password' => 'password',
            'confirmPassword' => 'password',
            'about' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.',
            'profile_pic' => $profile,
            'profile_cover' => $cover,
            'is_admin' => false,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('users.store'), $newUser);

        $response->assertSessionHasErrors(['fullname', 'username', 'email', 'password', 'about', 'profile_pic', 'profile_cover']);
        $response->assertInvalid(['fullname', 'username', 'email', 'password', 'about', 'profile_pic', 'profile_cover']);
    }

    public function test_non_admin_users_cannot_update_user(): void
    {
        $user = User::factory()->create();
        $user['email'] = 'test@yahoo.com';

        $response = $this->actingAs($this->user)
            ->put(route('users.update', ['user' => $user->username]), $user->toArray());

        $response->assertStatus(403);
    }

    public function test_admin_users_update_user_successful(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->put(route('users.update', ['user' => $user->username]), [

                'fullname' => 'John Smith',
                'username' => 'johnnyplaytheguitar',
                'email' => 'smith@yahoo.com',
            ]);

        $response->assertSessionHas('success');

        $this->assertEquals('smith@yahoo.com', User::get()->last()['email']);
    }

    public function test_update_user_redirects_and_returns_validation_errors()
    {
        $user = User::factory()->create();
        Storage::fake('profile');
        Storage::fake('cover');

        $profile = UploadedFile::fake()->image('profile.jpg')->size(2000);
        $cover = UploadedFile::fake()->image('cover.jpg')->size(3000);

        $response = $this->actingAs($this->adminUser)->put(route('users.update', ['user' => $user->username]), [

            'fullname' => '7im0thy F0rr3st',
            'username' => 'TheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImagined',
            'email' => 'doeatmaildotcom',
            'password' => 'password',
            'confirmPassword' => 'password',
            'about' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.',
            'profile_pic' => $profile,
            'profile_cover' => $cover,
        ]);

        $response->assertSessionHasErrors(['fullname', 'username', 'email', 'password', 'about', 'profile_pic', 'profile_cover']);
        $response->assertInvalid(['fullname', 'username', 'email', 'password', 'about', 'profile_pic', 'profile_cover']);
    }

    public function test_non_admin_users_cannot_remove_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('users.destroy', ['user' => $user->username]));

        $response->assertStatus(403);
    }

    public function test_admin_users_remove_user_successful(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->delete(route('users.destroy', ['user' => $user->username]));

        $response->assertSessionHas('success');
        $this->assertTrue(User::get()->count() === 2);
    }

    public function test_non_admin_users_cannot_restore_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->post(route('users.restore', ['user' => $user->username]));

        $response->assertStatus(403);
    }

    public function test_admin_users_restore_user_successful(): void
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.restore', ['user' => $user->username]));

        $response->assertSessionHas('success');
        $this->assertTrue(User::get()->count() === 3);
    }

    public function test_non_admin_users_cannot_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->post(route('users.erase', ['user' => $user->username]));

        $response->assertStatus(403);
    }

    public function test_admin_users_delete_user_successful(): void
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.erase', ['user' => $user->username]));

        $response->assertSessionHas('success');
        $this->assertTrue(User::onlyTrashed()->get()->count() === 0);
    }

    public function test_admin_users_delete_user_successful_with_profile_and_cover_images(): void
    {
        Storage::fake('profile');
        Storage::fake('cover');
        $profile = UploadedFile::fake()->image('profile.jpg')->size(800);
        $cover = UploadedFile::fake()->image('cover.jpg')->size(800);
        Storage::disk('profile')->putFileAs('/', $profile, $profile->hashName());
        Storage::disk('cover')->putFileAs('/', $cover, $cover->hashName());
        $user = User::factory()->create([
                                            'profile_pic' => $profile->hashName(),
                                            'profile_cover' => $cover->hashName(),
                                            'deleted_at' => now(),
                                        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('users.erase', ['user' => $user->username]));

        $response->assertSessionHas('success');
        $this->assertTrue(User::onlyTrashed()->get()->count() === 0);
        Storage::disk('profile')->assertMissing($profile->hashName());
        Storage::disk('cover')->assertMissing($cover->hashName());
    }
}
