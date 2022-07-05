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
        $genders = ['男', '女', 'その他'];

        return [
            'registered_date' => $this->faker->date('Y-m-d'),
            'family_name' => $this->faker->firstName,
            'given_name' => $this->faker->lastName,
            'family_name_kana' => $this->faker->last_kana_name,
            'given_name_kana' => $this->faker->first_kana_name(),
            'gender' => $genders[array_rand($genders, 1)],
            'grade' => mt_rand(1,16),
            'email' => $this->faker->email,
            'remarks' => $this->faker->text(200),
        ];
    }
}
