<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id');
            $table->unsignedINteger('cabinet_id');
            $table->enum('action', ['entry','exit']);
            $table->timestamp('action_at');

            $table->foreign('member_id')->references('id')->on('member');
            $table->foreign('cabinet_id')->references('id')->on('cabinet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workout');
    }
}
