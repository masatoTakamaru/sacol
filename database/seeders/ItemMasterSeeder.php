<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ItemMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("ItemMasterの作成を開始します...");
        $familyNamesSplFileObject = new \SplFileObject(__DIR__ . '/csv/item_master.csv');
        $familyNamesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($familyNamesSplFileObject as $key=>$row) {
            DB::table('item_masters')->insert([
                'user_id'=>trim($row[0]),
                'code'=>trim($row[1]),
                'category'=>trim($row[2]),
                'name'=>trim($row[3]),
                'price'=>trim($row[4]),
                'description'=>trim($row[5]),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $count++;
        }
        $this->command->info("ItemMasterを{$count}件作成しました。");
    }
}
