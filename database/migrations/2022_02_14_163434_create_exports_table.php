<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->char('code', 20);
            $table->char('item_id',20);
            $table->bigInteger('warehouse_id');
            $table->bigInteger('shelf_id');
            $table->bigInteger('supplier_id');
            $table->char('batch_code',20);
            $table->string('name');
            $table->integer('amount');
            $table->integer('price');
            $table->string('unit', 10);
            $table->char('status',1);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('exports');
    }

}
