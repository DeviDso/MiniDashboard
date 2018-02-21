<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned();
            $table->string('name');
            $table->integer('product_id')->nullable();
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('quantity');
            $table->string('note')->nullable();
            $table->decimal('bruto', 12, 2)->nullable();
            $table->decimal('netto', 12, 2)->nullable();
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
        Schema::dropIfExists('quotes_datas');
    }
}
