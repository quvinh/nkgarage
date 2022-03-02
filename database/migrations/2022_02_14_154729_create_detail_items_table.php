<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_items', function (Blueprint $table) {
            $table->id();
            $table->char('item_id', 20);
            $table->bigInteger('category_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('shelf_id');
            $table->char('batch_code', 20);
            $table->integer('amount');
            $table->string('unit', 10);
            $table->integer('price');
            $table->char('status',1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_items');
    }
}
