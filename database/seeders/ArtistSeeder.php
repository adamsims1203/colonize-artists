<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artists = array([
            'name' => "Ed Sheeran",
            'bio' => "Edward Christopher Sheeran MBE is an English singer-songwriter. Born in Halifax, West Yorkshire and raised in Framlingham, Suffolk, he began writing songs around the age of eleven. In early 2011, Sheeran independently released the extended play, No. 5 Collaborations Project.",
            'spotify_id' => "6eUKZXaKkcviH0Ku9w2n3V",
            "deezer_id" => "384236",
            "apple_id" => "183313439"
        ], [
            "name" => "Taylor Swift",
            "bio" => "Taylor Alison Swift is an American singer-songwriter. Her discography spans multiple genres, and her narrative songwriting, which is often inspired by her personal life, has received widespread media coverage and critical praise.",
            "spotify_id" => "06HL4z0CvFAxyc27GXpf02",
            "deezer_id" => "12246",
            "apple_id" => "159260351",
        ], [
            "name" => "Charlie Puth",
            "bio" => "Charles Otto Puth Jr. is an American singer, songwriter, and record producer. His initial exposure came through the viral success of his song videos uploaded to YouTube.",
            "spotify_id" => "6VuMaDnrHyPL1p4EHjYLi7",
            "deezer_id" => "1362735",
            "apple_id" => "336249253"
        ]);

        foreach($artists as $artist) {
            Artist::create($artist);
        }
    }
}
