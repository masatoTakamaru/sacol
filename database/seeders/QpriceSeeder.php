<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class QpriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("qpriceの作成を開始します...");
        $familyNamesSplFileObject = new \SplFileObject(__DIR__ . '/csv/qprice.csv');
        $familyNamesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($familyNamesSplFileObject as $key=>$row) {
            DB::table('qprices')->insert([
                'user_id'=>trim($row[0]),
                'sheet_id'=>trim($row[1]),
                'grade'=>trim($row[2]),
                'qprice'=>trim($row[3]),
                'price'=>trim($row[4]),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $count++;
        }
        $this->command->info("Itemを{$count}件作成しました。");
    }
}
