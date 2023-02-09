<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class ArtistsController extends Controller
{
    /**
     * @return Artist[]|Collection
     */
    public function get()
    {
        return Artist::all();
    }

     /**
     * Add artist
     */
    public function add(Request $request, SpotifyService $spotify_api)
    {
        // Find an artist on Spotify API
        $response = $spotify_api->findArtist($request->post('spotify_id'));

        // Check if the artist was not found
        if ($response['code'] == 404) {
            return response($response)->setStatusCode(404);
        }

        // Check if the artist already exists in the database
        if (Artist::where('spotify_id', $request->post('spotify_id'))->first()) {
            return response([
                'code' => 409,
                'message' => 'Already exist. Please enter another spotify id.'
            ])->setStatusCode(409);
        }

        // Create a new artist instance
        $artist = new Artist;

        // Populate the artist instance with data from the Spotify API response
        $artist->name = $response['data']->name;
        $artist->bio = $request['bio'];
        $artist->spotify_id = $response['data']->id;
        $artist->deezer_id = mt_rand(1000, 10000);
        $artist->apple_id = mt_rand(100000000, 999999999);
        $artist->avatar = $response['data']->images[2]->url;
        $artist->followers = $response['data']->followers->total;

        // Save the artist to the database
        $artist->save();

        return response([
            'code' => $response['code'],
            'message' => $response['message']
        ])->setStatusCode(200);
    }
}
