<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Studentの作成を開始します...");
        $familyNamesSplFileObject = new \SplFileObject(__DIR__ . '/csv/student.csv');
        $familyNamesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($familyNamesSplFileObject as $key=>$row) {
            if ($row[2]) {
                DB::table('students')->insert([
                    'user_id'=>trim((int) $row[0]),
                    'registered_date'=>trim($row[1]),
                    'expired_date'=>trim($row[2]),
                    'student_group'=>trim((int) $row[3]),
                    'family_name'=>trim($row[4]),
                    'given_name'=>trim($row[5]),
                    'family_name_kana'=>trim($row[6]),
                    'given_name_kana'=>trim($row[7]),
                    'gender'=>trim($row[8]),
                    'grade'=>trim((int) $row[9]),
                    'birth_date'=>trim($row[10]),
                    'school_attended'=>trim($row[11]),
                    'family_group'=>trim($row[12]),
                    'guardian_family_name'=>trim($row[13]),
                    'guardian_given_name'=>trim($row[14]),
                    'guardian_family_name_kana'=>trim($row[15]),
                    'guardian_given_name_kana'=>trim($row[16]),
                    'phone1'=>trim($row[17]),
                    'phone1_relationship'=>trim($row[18]),
                    'phone2'=>trim($row[19]),
                    'phone2_relationship'=>trim($row[20]),
                    'email'=>trim($row[21]),
    
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            } else {
                DB::table('students')->insert([
                    'user_id'=>trim((int) $row[0]),
                    'registered_date'=>trim($row[1]),
                    'student_group'=>trim((int) $row[3]),
                    'family_name'=>trim($row[4]),
                    'given_name'=>trim($row[5]),
                    'family_name_kana'=>trim($row[6]),
                    'given_name_kana'=>trim($row[7]),
                    'gender'=>trim($row[8]),
                    'grade'=>trim((int) $row[9]),
                    'birth_date'=>trim($row[10]),
                    'school_attended'=>trim($row[11]),
                    'family_group'=>trim($row[12]),
                    'guardian_family_name'=>trim($row[13]),
                    'guardian_given_name'=>trim($row[14]),
                    'guardian_family_name_kana'=>trim($row[15]),
                    'guardian_given_name_kana'=>trim($row[16]),
                    'phone1'=>trim($row[17]),
                    'phone1_relationship'=>trim($row[18]),
                    'phone2'=>trim($row[19]),
                    'phone2_relationship'=>trim($row[20]),
                    'email'=>trim($row[21]),
    
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            }

            $count++;
        }
        $this->command->info("Studentを{$count}件作成しました。");
    }
}
