<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member', function (Blueprint $table) {
            $table->string('national_code')->nullable(true)->default('0')->change();
            $table->string('telephone')->nullable(true)->change();
            $table->string('mobile_number')->nullable(true)->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member', function (Blueprint $table) {
            //
        });
    }
}
