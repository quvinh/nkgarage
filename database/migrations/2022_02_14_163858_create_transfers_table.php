<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->char('code', 20);
            $table->char('item_id', 20);
            $table->string('name');
            $table->integer('amount');
            $table->string('unit', 10);
            $table->bigInteger('from_warehouse');
            $table->bigInteger('from_shelf');
            $table->bigInteger('to_warehouse');
            $table->bigInteger('to_shelf');
            $table->bigInteger('supplier_id');
            $table->text('note')->nullable();
            $table->char('status',1);
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('transfers');
    }
}
