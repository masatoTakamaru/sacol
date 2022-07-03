<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sheet;


class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sheet = new Sheet();
        $sheet->user_id = 1;
        $sheet->year = 2022;
        $sheet->month = 4;
        $sheet->enrollment = 10;
        $sheet->sales = 123456;
        $sheet->save();
    }
}
