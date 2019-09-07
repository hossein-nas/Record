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


        App\Card::create([
            'uid' => '79-E5-CB-8E',
            'registered_at' => Carbon\Carbon::now(),
            'type' => 'user'
        ]);
        App\Card::create([
            'uid' => 'A7-E5-83-34',
            'registered_at' => Carbon\Carbon::now(),
            'type' => 'user'
        ]);

        $m = [
            'name' => 'hossein',
            'national_code' => "234234",
            'lastname' => 'nasiri',
            'address' => 'tehran',
            'telephone' => '02146887092',
            'mobile_number' => '09056638513',
            'card_id' => 1
        ];
        $n = [
            'name' => 'Yashar',
            'national_code' => "234235",
            'lastname' => 'Bagheri',
            'address' => 'tehran',
            'telephone' => '02146887092',
            'mobile_number' => '09056638513',
            'card_id' => 2
        ];
        $admin = [
            'name' => 'Alireza',
            'lastname' => 'AliAkbar',
            'card_id' => 2
        ];

        App\Member::create($m);
        App\Member::create($n);
        App\Admin::create($admin);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::table('plan')->truncate();
        // DB::table('cabinet')->truncate();
    }
}
