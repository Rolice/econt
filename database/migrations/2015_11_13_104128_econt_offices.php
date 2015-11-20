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
            $table->unsignedInteger('neighbourhood_id')->index('idx_neighbourhood_id')->nullable()->default(null);
            $table->string('name');
            $table->string('name_en');
            $table->unsignedInteger('code')->unique('uk_code');
            $table->string('phone')->nullable()->default(null);
            $table->string('address');
            $table->string('address_en');
            $table->string('city');
            $table->string('city_en');
            $table->string('neighbourhood')->nullable()->default(null);
            $table->string('street')->nullable()->default(null);
            $table->string('street_num')->nullable()->default(null);
            $table->string('bl')->nullable()->default(null);
            $table->string('vh')->nullable()->default(null);
            $table->string('et')->nullable()->default(null);
            $table->string('ap')->nullable()->default(null);
            $table->string('other')->nullable()->default(null);
            $table->time('work_begin')->nullable()->default(null);
            $table->time('work_end')->nullable()->default(null);
            $table->time('work_begin_saturday')->nullable()->default(null);
            $table->time('work_end_saturday')->nullable()->default(null);
            $table->time('priority')->index('idx_priority')->nullable()->default(null);
            $table->datetime('updated_time')->nullable()->default(null);
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
