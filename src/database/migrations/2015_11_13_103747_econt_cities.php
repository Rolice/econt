<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_cities', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('post_code')->unique('uk_post_code');
            $table->unsignedInteger('zone_id')->index('idx_zone');
            $table->unsignedInteger('country_id')->index('idx_country');
            $table->unsignedInteger('office_id')->index('idx_office_id');
            $table->enum('type', ['city', 'village'])->nullable()->default(null)->index('idx_type');
            $table->string('name');
            $table->string('name_en');
            $table->string('region');
            $table->string('region_en');
            $table->unsignedTinyInteger('service_days')->index('idx_service_days');
            $table->timestamps();

            $table->unsignedInteger('courier_from_door');
            $table->unsignedInteger('courier_to_door');
            $table->unsignedInteger('courier_from_office');
            $table->unsignedInteger('courier_to_office');

            $table->unsignedInteger('cargo_pallet_from_door');
            $table->unsignedInteger('cargo_pallet_to_door');
            $table->unsignedInteger('cargo_pallet_from_office');
            $table->unsignedInteger('cargo_pallet_to_office');

            $table->unsignedInteger('cargo_express_from_door');
            $table->unsignedInteger('cargo_express_to_door');
            $table->unsignedInteger('cargo_express_from_office');
            $table->unsignedInteger('cargo_express_to_office');

            $table->unsignedInteger('post_from_door');
            $table->unsignedInteger('post_to_door');
            $table->unsignedInteger('post_from_office');
            $table->unsignedInteger('post_to_office');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_cities');
    }
}
