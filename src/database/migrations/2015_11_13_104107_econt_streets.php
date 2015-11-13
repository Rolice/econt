<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontStreets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_streets', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city');
            $table->string('name');
            $table->string('name_en');
            $table->unsignedInteger('city_post_code')->index('idx_city_post_code');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_streets');
    }
}
