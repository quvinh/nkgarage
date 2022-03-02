<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->char('item_id', 20);
            $table->char('code', 20);
            $table->char('batch_code', 20);
            $table->bigInteger('warehouse_id');
            $table->bigInteger('category_id');
            $table->bigInteger('shelf_id');
            $table->string('name');
            $table->integer('amount');
            $table->string('unit', 10);
            $table->integer('price');
            $table->char('status',1);
            $table->char('suppliers_id', 20);
            $table->bigInteger('created_by');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('imports');
    }
}
