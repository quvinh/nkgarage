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
            $table->char('item_id', 20)->nullable();
            $table->string('item_name')->nullable();
            $table->string('title');
            $table->text('content');
            $table->integer('amount')->nullable();
            $table->string('unit', 10)->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('created_by');
            $table->char('code', 20);
            $table->char('status',1);
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
