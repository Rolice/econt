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
            $table->unsignedInteger('zone_id')->index('idx_zone_id')->nullable()->default(null);
            $table->unsignedInteger('office_id')->index('idx_office_id')->nullable()->default(null);
            $table->string('post_code', 50)->nullable()->default(null);
            $table->string('name');
            $table->string('name_en');
            $table->string('region');
            $table->string('region_en');
            $table->unsignedInteger('hub_code');
            $table->string('hub_name')->nullable()->default(null);
            $table->string('hub_name_en')->nullable()->default(null);
            $table->unsignedTinyInteger('service_days')->index('idx_service_days');
            $table->timestamps();

            $table->unsignedInteger('courier_from_door')->nullable()->default(null);
            $table->unsignedInteger('courier_to_door')->nullable()->default(null);
            $table->unsignedInteger('courier_from_office')->nullable()->default(null);
            $table->unsignedInteger('courier_to_office')->nullable()->default(null);

            $table->unsignedInteger('cargo_pallet_from_door')->nullable()->default(null);
            $table->unsignedInteger('cargo_pallet_to_door')->nullable()->default(null);
            $table->unsignedInteger('cargo_pallet_from_office')->nullable()->default(null);
            $table->unsignedInteger('cargo_pallet_to_office')->nullable()->default(null);

            $table->unsignedInteger('cargo_express_from_door')->nullable()->default(null);
            $table->unsignedInteger('cargo_express_to_door')->nullable()->default(null);
            $table->unsignedInteger('cargo_express_from_office')->nullable()->default(null);
            $table->unsignedInteger('cargo_express_to_office')->nullable()->default(null);

            $table->unsignedInteger('post_from_door')->nullable()->default(null);
            $table->unsignedInteger('post_to_door')->nullable()->default(null);
            $table->unsignedInteger('post_from_office')->nullable()->default(null);
            $table->unsignedInteger('post_to_office')->nullable()->default(null);
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
