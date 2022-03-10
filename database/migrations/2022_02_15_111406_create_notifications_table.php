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
            $table->string('title');
            $table->text('content');
            $table->char('code',20);
            $table->char('item_id',20)->nullable();
            $table->integer('amount')->nullable();
            $table->string('unit', 10)->nullable();
            $table->bigInteger('created_by');
            $table->char('status',2)->nullable();
            $table->dateTime('begin_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->char('type',1);
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
