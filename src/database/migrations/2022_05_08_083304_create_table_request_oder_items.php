<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_order_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('item_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('request_order_id')
                ->references('id')
                ->on('request_orders');
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus');
            $table->foreign('item_id')
                ->references('id')
                ->on('menu_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_order_items');
    }
};
