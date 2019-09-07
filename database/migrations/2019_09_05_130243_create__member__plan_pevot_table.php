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
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('admin_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('finished_at')->nullable();

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
