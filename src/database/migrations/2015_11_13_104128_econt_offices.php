<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontOffices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_offices', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_offices');
    }
}
