<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class QtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Qtyの作成を開始します...");
        $familyNamesSplFileObject = new \SplFileObject(__DIR__ . '/csv/qty.csv');
        $familyNamesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($familyNamesSplFileObject as $key=>$row) {
            DB::table('qtys')->insert([
                'user_id'=>trim($row[0]),
                'period'=>trim($row[1]),
                'grade'=>trim($row[2]),
                'qty'=>trim($row[3]),
                'price'=>trim($row[4]),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $count++;
        }
        $this->command->info("Itemを{$count}件作成しました。");
    }
}
