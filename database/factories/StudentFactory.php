<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'registered_date' => '2021-01-01',
            'family_name' => $this->faker->firstName,
            'given_name' => $this->faker->lastName,
            'family_name_kana' => 'アイウエオ',
            'given_name_kana' => 'アイウエオ',
            'gender' => $this->faker->randomElement(['男', '女', 'その他']),
            'grade' => mt_rand(1,16),
            'email' => $this->faker->userName() . '@gmail.com',
            'remarks' => $this->faker->text(200),
        ];
    }
}
