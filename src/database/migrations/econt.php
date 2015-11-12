<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Econt extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('econt_zones', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->string('name_en');
            $table->boolean('national')->default(0)->index('idx_national');
            $table->boolean('is_ee')->default(1)->index('idx_is_ee');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('econt_countries', function(Blueprint $table) {
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

        Schema::create('econt_cities', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('post_code')->unique('uk_post_code');
            $table->unsignedInteger('zone_id')->index('idx_zone');
            $table->unsignedInteger('country_id')->index('idx_country');
            $table->unsignedInteger('office_id')->index('idx_office_id');
            $table->enum('type', ['city', 'village'])->nullable()->default('null')->index('idx_type');
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

        Schema::create('econt_regions', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city_id');
            $table->string('name')->nullable()->default(null);
            $table->unsignedInteger('code')->index('idx_code');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('econt_neighbourhoods', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city');
            $table->string('name');
            $table->string('name_en');
            $table->unsignedInteger('city_post_code')->index('idx_city_post_code');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('econt_streets', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city');
            $table->string('name');
            $table->string('name_en');
            $table->unsignedInteger('city_post_code')->index('idx_city_post_code');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('econt_offices', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('city_id')->index('idx_city');
            $table->unsignedInteger('street_id')->index('idx_street_id')->nullable()->default(null);
            $table->unsignedInteger('neighbourhood_id')->index('idx_neighbourhood_id');
            $table->string('name');
            $table->string('name_en');
            $table->unsignedInteger('code')->unique('uk_code');
            $table->string('phone')->nullable()->default(null);
            $table->string('address');
            $table->string('address_en');
            $table->string('city');
            $table->string('city_en');
            $table->string('neighbourhood');
            $table->string('street')->nullable()->default(null);
            $table->string('street_num')->nullable()->default(null);
            $table->string('bl')->nullable()->default(null);
            $table->string('vh')->nullable()->default(null);
            $table->string('et')->nullable()->default(null);
            $table->string('ap')->nullable()->default(null);
            $table->string('other')->nullable()->default(null);
            $table->time('work_begin');
            $table->time('work_end');
            $table->time('work_begin_saturday');
            $table->time('work_end_saturday');
            $table->time('priority')->index('idx_priority');
            $table->timestamps();

            $table->primary('id');

            DB::statement('ALTER TABLE econt_offices ADD COLUMN location POINT NULL DEFAULT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::setConnection(DB::connection('auth'))->drop('invoicing');
        DB::statement('ALTER TABLE econt_offices DROP COLUMN location RESTRICT');
    }
}