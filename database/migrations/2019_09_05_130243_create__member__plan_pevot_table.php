<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPlanPevotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id');
            $table->integer('plan_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->timestamp('start_at');
            $table->timestamp('finished_at');

            $table->foreign('member_id')->references('id')->on('member');
            $table->foreign('admin_id')->references('id')->on('admin');
            $table->foreign('plan_id')->references('id')->on('plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_plan');
    }
}
