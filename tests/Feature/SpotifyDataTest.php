<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Artist;
use Tests\TestCase;

class SpotifyDataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The test case should see the 3 fields of test artist data.
     *
     * @return void
     */
    public function test_should_see_3_fields()
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
        $this->postJson('/api/artists/add', $testData);

        // we should find the first artist from the artist table since the table contains softDeletes
        $artist = Artist::first();
        // check the artist detail view
        $view = $this->get('view/' . $artist->id);
        $view
            ->assertSee($testData['name'])
            ->assertSee($testData['spotify_id'])
            ->assertSee($testData['bio']);
    }
}
