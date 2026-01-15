<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'nis' => $this->faker->unique()->numerify('######'),
            'rfid_code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'class_name' => '10',
            'role' => 'santri',
            'password' => bcrypt('password'), // Explicit password
        ];
    }
}
