<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile',15)->uneque();
            $table->string('card_num',15);
            $table->decimal('balance');
            $table->decimal('recharged_total');
            $table->decimal('consumed_total');
            $table->timestamps();
            $table->index(['mobile','card_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
