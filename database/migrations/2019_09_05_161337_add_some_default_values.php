<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tuples = [
            [
                'name' => 'یک روزه',
                'price' => 70000,
                'period' => 1
            ],
            [
                'name' => 'یک ماهه',
                'price' => 700000,
                'period' => 30
            ],
            [
                'name' => 'سه ماهه',
                'price' => 2100000,
                'period' => 90
            ]
        ];

        foreach ( $tuples as $tuple){
            App\Plan::create($tuple);
        }
        $cabinet_counts = (new \App\Cabinet() )->getCabinetCounts();
        for ( $i = 1; $i <= $cabinet_counts ; $i++ ){
            App\Cabinet::create([
                'cabinet_no' => $i
            ]);
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('plan')->truncate();
        DB::table('cabinet')->truncate();
    }
}
