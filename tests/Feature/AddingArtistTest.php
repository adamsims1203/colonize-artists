<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\User;
use Tests\TestCase;

class AddingArtistTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * This test case should add artist
     *
     * @return void
     */
    public function test_should_add_artist()
    {
        $testUser = User::factory()->create();
        $testData = [
            'name' => 'Pitbull',
            'spotify_id' => '0TnOYISbd1XYRBk9myaseg',
            'bio' => 'Test Bio'
        ];

        // login
        $this->actingAs($testUser);
        
        // add new artist
        $response = $this->postJson('/api/artists/add', $testData);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json
                    ->where('code', 200)
                    ->where('message', 'success')
                    ->etc()
            );
    }

    /**
     * This test case should be already exist
     *
     * @return void
     */
    public function test_shoulde_be_already_exist()
    {
        $testUser = User::factory()->create();
        $testData = [
            'name' => 'Pitbull',
            'spotify_id' => '0TnOYISbd1XYRBk9myaseg',
            'bio' => 'Test Bio'
        ];

        // login
        $this->actingAs($testUser);
        
        // add new artist (first)
        $response = $this->postJson('/api/artists/add', $testData);

        // add new artist with same data (second)
        $response = $this->postJson('/api/artists/add', $testData);

        $response
            ->assertStatus(409)
            ->assertJson(fn (AssertableJson $json) => 
                $json
                    ->where('code', 409)
                    ->where('message', 'Already exist. Please enter another spotify id.')
                    ->etc()
            );
    }

    /**
     * This test case should be not found
     *
     * @return void
     */
    public function test_should_be_not_found()
    {
        $testUser = User::factory()->create();
        $testData = [
            'name' => 'Pitbull',
            'spotify_id' => '1TnOYISbd1XYRBk9myaseg', // invalid spotify id
            'bio' => 'Test Bio'
        ];

        // login
        $this->actingAs($testUser);
        
        // add new artist
        $response = $this->postJson('/api/artists/add', $testData);

        $response
            ->assertStatus(404)
            ->assertJson(fn (AssertableJson $json) => 
                $json
                    ->where('code', 404)
                    ->where('message', 'The spotify id is invalid.')
                    ->etc()
            );
    }
}
