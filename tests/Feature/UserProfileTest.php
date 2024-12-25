<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Rules\Fullname;
use App\Rules\MaxCharacter;
use App\Livewire\User\Profile;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;

class UserProfileTest extends TestCase
{
    public User $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    public function test_non_authenticated_user_cannot_access_profile_page(): void
    {
        $newUser = User::factory()->create();

        $response = $this->get(route('user.profile', ['user' => $newUser->username]));

        $response->assertRedirect(route('login.index'));
    }

    public function test_other_users_cannot_access_another_user_profile_page(): void
    {
        $newUser = User::factory()->create();

        $response = $this->actingAs($this->user)->get(route('user.profile', ['user' => $newUser->username]));

        $response->assertStatus(403);
    }

    public function test_users_can_access_their_own_profile_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('user.profile', ['user' => $this->user->username]));

        $response->assertStatus(200);
    }

    // public function test_user_update_profile_successful(): void
    // {
    //     Livewire::actingAs($this->user)->test(Profile::class, ['user' => $this->user])
    //             ->set([
    //                 'about' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.',
    //                 'fullname' => 'Timothy Forrest',
    //                 'username' => 'Tim4Rest',
    //                 'email' => 'forrest@gmail.com',
    //                 'phone_country' => 'ID',
    //                 'phone' => '0819555831',
    //                 'website' => 'www.fakewebsite.com',
    //                 'date_of_birth' => Carbon::now()->subYears(10)->format('Y-m-d'),
    //             ])
    //             ->call('update')
    //             ->assertHasNoErrors([
    //                 'about' => new MaxCharacter(200),
    //                 'fullname' => new Fullname,
    //                 'username' => 'max:255',
    //                 'email' => 'email:dns',
    //                 'phone_country' => 'required_with:phone',
    //                 'phone' => 'phone',
    //                 'website' => 'url',
    //                 'date_of_birth' => 'date',
    //             ]);
    // }

    // public function test_profile_user_update_redirects_and_returns_validation_errors()
    // {
    //     Livewire::actingAs($this->user)->test(Profile::class, ['user' => $this->user])
    //             ->set([
    //                 'about' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.',
    //                 'fullname' => '7im0thy F0rr3st',
    //                 'username' => 'TheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImaginedTheEmperorsNewClothesOfTheMostMagnificentAndExtravagantFabricEverImagined',
    //                 'email' => 'forrestatmail.com',
    //                 'phone_country' => 'IE',
    //                 'phone' => '0234555831',
    //                 'website' => 'wwwdotfakewebsitedotcom',
    //                 'date_of_birth' => Carbon::now()->subYears(10)->format('Y-m-d'),
    //             ])
    //             ->call('update')
    //             ->assertHasErrors([
    //                 'about' => new MaxCharacter(200),
    //                 'fullname' => new Fullname,
    //                 'username' => 'max:255',
    //                 'email' => 'email:dns',
    //                 'phone_country' => 'required_with:phone',
    //                 'phone' => 'phone',
    //                 'website' => 'url',
    //                 'date_of_birth' => 'date',
    //             ]);
    // }
}
