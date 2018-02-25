<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('vat')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_street')->nullable();
            $table->string('delivery_post_code')->nullable();
            $table->string('delivery_country')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('courier_account')->nullable();
            $table->integer('credit_amount')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
