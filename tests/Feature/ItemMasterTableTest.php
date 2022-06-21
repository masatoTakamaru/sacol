<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ItemMasterRequest;

class ItemMasterTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider dataprovider
     * @test
     */
    public function ItemMasterテーブルのバリデーションテスト($data, $expect)
    {
        $request = new ItemMasterRequest();
        $rules = $request->rules();
        $validator = Validator::make($data, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
        dump($validator->messages()->first());
        dump($data['price']);
    }

    public function dataprovider()
    {
        return [
            '正常' => [
                [
                    'code' => '1001',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                true
            ],
            'コードが負の数はNG' => [
                [
                    'code' => '-1',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            'コードが0はNG' => [
                [
                    'code' => '0',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            'コードが10000以上はNG' => [
                [
                    'code' => '10000',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            'コードが全角文字はNG' => [
                [
                    'code' => '１００',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            '種別が未選択はNG' => [
                [
                    'code' => '1011',
                    'category' => '',
                    'name' => '中１国語',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            '科目名が空白はNG' => [
                [
                    'code' => '1011',
                    'category' => '1',
                    'name' => '',
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            '科目名が21字以上はNG' => [
                [
                    'code' => '1011',
                    'category' => '1',
                    'name' => str_repeat('あ', 21),
                    'price' => '8800',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
            '従量課金型の場合価格が空白はOK' => [
                [
                    'code' => '1011',
                    'category' => '1',
                    'name' => '中１国語',
                    'price' => '',
                    'description' => '中学１年国語通期講座',
                ],
                true
            ],
            '従量課金型以外の場合価格が空白はNG' => [
                [
                    'code' => '1011',
                    'category' => '2',
                    'name' => '中１国語',
                    'price' => '',
                    'description' => '中学１年国語通期講座',
                ],
                false
            ],
        ];
    }
}
