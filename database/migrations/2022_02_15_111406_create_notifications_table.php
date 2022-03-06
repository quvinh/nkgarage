<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('detail_item_id')->nullable();
            $table->char('item_id', 20);
            $table->string('item_name');
            $table->string('title');
            $table->text('content');
            $table->integer('amount');
            $table->string('unit', 10);
            $table->bigInteger('warehouse_id');
            $table->bigInteger('created_by');
            $table->char('code', 20);
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
        Schema::dropIfExists('notifications');
    }
}
