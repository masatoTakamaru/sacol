<?php

namespace Tests\Feature\tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class QpriceEditTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @test
     * @group qprice
     */
    public function 従量課金型科目の設定が表示される()
    {
        
    }
}
