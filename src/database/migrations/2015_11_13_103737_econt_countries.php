<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_countries', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('zone_id')->index('idx_zone_id');
            $table->unsignedInteger('office_id')->index('idx_office_id');
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
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_countries');
    }
}
