<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StudentRequest;


class StudentsTableTest extends TestCase
{

    use RefreshDatabase;

    protected $seed = true;

    /**
     * @dataProvider dataprovider
     * @test
     */
    public function studentsテーブルのバリデーションテスト($data, $expect)
    {
        $request = new StudentRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
        dump($validator->messages()->first());
    }

    public function dataprovider()
    {
        return [
            '正常' => [
                [
                    'registered_date' => '2022-1-1',
                    'expired_flg' => '1',
                    'expired_date' => '2022-4-1',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'birth_date' => '2005-10-10',
                    'school_attended' => 'サンプル中学校',
                    'guardian_family_name' => '田中',
                    'guardian_given_name' => '次郎',
                    'guardian_family_name_kana' => 'タナカ',
                    'guardian_given_name_kana' => 'ジロウ',
                    'phone1' => '03-1234-5678',
                    'phone1_relationship' => '自宅',
                    'phone2' => '090-1234-5678',
                    'phone2_relationship' => '携帯',
                    'email' => 'test@gmail.com',
                    'remarks' => 'サンプルメッセージ',
                ],
                true
            ],
            '入会日が空白はNG' => [
                [
                    'registered_date' => '',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '退会日が空白はOK' => [
                [
                    'registered_date' => '2021-12-30',
                    'expired_date' => '',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                true
            ],
            '生徒姓が空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒姓が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => str_repeat('ア', 21),
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒名が空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒名が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => str_repeat('ア', 21),
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒姓フリガナが空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => '',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒姓フリガナが全角カタカナ以外はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'ﾀﾅｶ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒姓フリガナが21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => str_repeat('ア', 21),
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒名フリガナが空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => '',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒名フリガナが全角カタカナ以外はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'ﾀﾛｳ',
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '生徒名フリガナが21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => str_repeat('ア', 21),
                    'gender' => '男',
                    'grade' => '1',
                ],
                false
            ],
            '性別が空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '',
                    'grade' => '1',
                ],
                false
            ],
            '学年が空白はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '',
                ],
                false
            ],
            '学校名が41字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'school_attended' => str_repeat('あ', 41),
                ],
                false
            ],
            '保護者姓が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_family_name' => str_repeat('あ', 21),
                ],
                false
            ],
            '保護者名が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_given_name' => str_repeat('あ', 21),
                ],
                false
            ],
            '保護者姓フリガナが全角カタカナ以外はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_family_name_kana' => 'ﾀﾅｶ',
                ],
                false
            ],
            '保護者姓フリガナが21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_family_name_kana' => str_repeat('あ', 21),
                ],
                false
            ],
            '保護者名フリガナが全角カタカナ以外はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_given_name_kana' => 'ｼﾞﾛｳ',
                ],
                false
            ],
            '保護者名フリガナが21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'guardian_given_name_kana' => str_repeat('あ', 21),
                ],
                false
            ],
            '電話番号1がハイフン無しはNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone1' => '0312345678',
                ],
                false
            ],
            '電話番号1が全角はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone1' => '０３－１２３４－５６７８',
                ],
                false
            ],
            '電話番号1が桁数が不正はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone1' => '03-1234-567890',
                ],
                false
            ],
            '電話番号1続柄が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone1_relationship' => str_repeat('あ', 21),
                ],
                false
            ],
            '電話番号2がハイフン無しはNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone2' => '0312345678',
                ],
                false
            ],
            '電話番号2が全角はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone2' => '０３－１２３４－５６７８',
                ],
                false
            ],
            '電話番号2が桁数が不正はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone2' => '03-1234-567890',
                ],
                false
            ],
            '電話番号2続柄が21字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'phone2_relationship' => str_repeat('あ', 21),
                ],
                false
            ],
            'メールアドレスが@無しはNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'email' => 'testgmail.com',
                ],
                false
            ],
            'メールアドレスに@@がある場合はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'email' => 'test@@gmail.com',
                ],
                false
            ],
            'メールアドレスが全角はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'email' => 'ｔｅｓｔ＠ｇｍａｉｌ．ｃｏｍ',
                ],
                false
            ],
            'メールアドレスが存在しないドメイン名はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'email' => 'test@gmail.net',
                ],
                false
            ],
            '備考欄が201字以上はNG' => [
                [
                    'registered_date' => '2021-12-30',
                    'family_name' => '田中',
                    'given_name' => '太郎',
                    'family_name_kana' => 'タナカ',
                    'given_name_kana' => 'タロウ',
                    'gender' => '男',
                    'grade' => '1',
                    'remarks' => str_repeat('あ', 201),
                ],
                false
            ],


        ];
    }
}
