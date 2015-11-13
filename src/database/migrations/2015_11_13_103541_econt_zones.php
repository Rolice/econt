<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontZones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_zones', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->string('name_en');
            $table->boolean('national')->default(0)->index('idx_national');
            $table->boolean('is_ee')->default(1)->index('idx_is_ee');
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
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_zones');
    }
}
