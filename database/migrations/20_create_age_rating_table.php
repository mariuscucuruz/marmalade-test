<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class createAgeRatingTable extends Migration
{
    public const TABLE_NAME = 'age_rating';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, static function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age')->index();
            $table->double('rating_factor', 10, 2)->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => 'AgeRatingTableSeeder']);
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
