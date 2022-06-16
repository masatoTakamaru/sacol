<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Itemの作成を開始します...");
        $familyNamesSplFileObject = new \SplFileObject(__DIR__ . '/csv/item.csv');
        $familyNamesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($familyNamesSplFileObject as $key=>$row) {
            DB::table('items')->insert([
                'student_id'=>trim($row[0]),
                'code'=>trim($row[1]),
                'period'=>trim($row[2]),
                'category'=>trim($row[3]),
                'name'=>trim($row[4]),
                'price'=>trim($row[5]),
                'description'=>trim($row[6]),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $count++;
        }
        $this->command->info("Itemを{$count}件作成しました。");
    }
}
