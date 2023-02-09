<?php

namespace App\Services;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Illuminate\Support\Facades\Cache;
use Exception;

class SpotifyService
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var SpotifyWebAPI
     */
    private $api;

    /**
     * SpotifyService constructor.
     */
    public function __construct()
    {
        $this->authenticate();

        $this->api = new SpotifyWebAPI();
        $this->api->setAccessToken($this->accessToken);
    }

    /**
     * @param $identifier
     */
    public function findArtist($identifier)
    {
        try {
            $artist = $this->api->getArtist($identifier);

            return [
                "code" => 200,
                "message" => "success",
                "data" => $artist
            ];
        } catch (Exception $e) {
            // none existing id
            if($e->getCode() == 404) {
                return [
                    "code" => $e->getCode(),
                    "message" => 'The spotify id is invalid.'
                ];
            }
        }
    }

    /**
     * Set up authentication so requests can be made to Spotify API
     */
    private function authenticate()
    {
        if(Cache::has('spotify_access_token')) {
            $this->accessToken = Cache::get('spotify_access_token');
        } else {
            $session = new Session(
                env("SPOTIFY_CLIENT_ID"), env("SPOTIFY_CLIENT_SECRET")
            );
            $session->requestCredentialsToken();
            $this->accessToken = $session->getAccessToken();
            Cache::put('spotify_access_token', $this->accessToken, now()->addHour());
        }
    }
}
