<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Artist;
use App\Services\SpotifyService;

class UpdateArtistFollowers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SpotifyService $spotify_api)
    {
        // Retrieve all artists from the database
        $artists = Artist::all();

        // Loop through each artist
        foreach ($artists as $key => $artist) {
            $response = $spotify_api->findArtist($artist->spotify_id);

            // Check if the response from the Spotify API is successful
            if ($response['code'] == 200) {
                // Update the artist's followers count
                $artist->followers = $response['data']->followers->total;

                // Save the updated artist back to the database
                $artist->save();
            }
        }
    }
}
