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
            $table->string('name');
            $table->bigInteger('category_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('shelf');
            $table->integer('amount');
            $table->string('unit', 10);
            $table->binary('status');
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
