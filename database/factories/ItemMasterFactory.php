<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemMaster>
 */
class ItemMasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $genders = ['男', '女', 'その他'];

        return [
            'code' => mt_rand(5000,6000),
            'category' => mt_rand(1,4),
            'name' => $this->faker->text(10),
            'price' => mt_rand(0,999999),
            'description' => $this->faker->text(50),
        ];
    }
}
