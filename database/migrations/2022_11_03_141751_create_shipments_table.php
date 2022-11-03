<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_code',100)->nullable();
            $table->string('addressee',255)->nullable();
            $table->string('customer_name',255)->nullable();
            $table->text('address')->nullable();
            $table->string('comune',255)->nullable();
            $table->string('region',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('contact_phone',20)->nullable();
            $table->string('contact_email',255)->nullable();
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
        Schema::dropIfExists('shipments');
    }
}
