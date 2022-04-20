<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class createPostcodeRatingTable extends Migration
{
    public const TABLE_NAME = 'postcode_rating';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, static function (Blueprint $table) {
            $table->increments('id');
            $table->string('postcode_area', 4)->index();
            $table->double('rating_factor', 10, 2)->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => 'PostcodeRatingTableSeeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
