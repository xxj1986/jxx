<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile',15);
            $table->decimal('balance');
            $table->decimal('recharged');
            $table->decimal('consumed');
            $table->string('remark', 60);
            $table->timestamp('created_at');
            $table->index(['mobile','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_records');
    }
}
