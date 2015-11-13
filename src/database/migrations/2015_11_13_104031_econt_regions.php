<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_regions', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city_id');
            $table->string('name')->nullable()->default(null);
            $table->unsignedInteger('code')->index('idx_code');
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
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_regions');
    }
}
