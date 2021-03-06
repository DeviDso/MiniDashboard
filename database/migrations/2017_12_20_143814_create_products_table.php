<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->uniqiue();
            $table->string('alternative_code')->nullable();
            $table->decimal('bruto', 12, 2)->nullable();
            $table->decimal('netto', 12, 2)->nullable();
            $table->integer('quantity');
            $table->decimal('price', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->string('warehouse_location')->nullable();
            $table->integer('warehouse')->unsigned()->nullable();
            $table->foreign('warehouse')->references('id')->on('warehouses')->onDlete('set null');
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
        Schema::dropIfExists('products');
    }
}
