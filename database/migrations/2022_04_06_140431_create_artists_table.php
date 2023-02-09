<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('spotify_id')->nullable();
            $table->string('deezer_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
