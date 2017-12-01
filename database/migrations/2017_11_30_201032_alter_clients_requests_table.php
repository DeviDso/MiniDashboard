<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClientsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients_requests', function($table){
            $table->dropColumn('title');
            $table->dropColumn('order_status_id');
            $table->integer('request_status_id');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients_requests', function($table){
            $table->string('title');
            $table->integer('order_status_id');
            $table->dropColumn('note');
            $table->dropColumn('request_status_id');
        });
    }
}
