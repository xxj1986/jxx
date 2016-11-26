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
            $table->string('mobile',15)->uneque()->index();
            $table->string('card_num',15)->index();
            $table->decimal('real_total');
            $table->decimal('balance');
            $table->decimal('recharged_total');
            $table->decimal('consumed_total');
            $table->tinyInteger('frozen');
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
        Schema::dropIfExists('members');
    }
}
