<?php

namespace Database\Seeders;

use App\Models\QualityCheckCode;
use Illuminate\Database\Seeder;

class QcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $qc_names = ['No Issue', 'Body Crack', 'Bump', 'Dent', 'Base Crack',
        'Overweight', 'Underweight', 
        'Pin Hole', 'POP (Plaster)', 'Seamline Crack',
        'Socket Crack', 'Thick Seamline', 'Soft Cast',
        'Axis Off', 'Socket drop', 'Filing Check Weight'];

        for($i = 0; $i < count($qc_names); $i++){
            QualityCheckCode::insert([
                'qc_code' => $i,
                'qc_name' =>  $qc_names[$i]
            ]);
        }
    }
}
