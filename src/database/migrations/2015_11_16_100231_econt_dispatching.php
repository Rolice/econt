<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcontDispatching extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->create('econt_dispatching', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('settlement_id');
            $table->enum('direction', ['from_door', 'to_door', 'from_office', 'to_office'])->index('idx_direction');
            $table->enum('shipment', ['courier', 'cargo_pallet', 'cargo_express', 'post'])->index('idx_shipment');
            $table->unsignedInteger('office_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::setConnection(DB::connection(Config::get('econt.connection')))->dropIfExists('econt_dispatching');
    }
}
