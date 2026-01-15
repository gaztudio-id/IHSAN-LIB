<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'publisher' => $this->faker->company,
            'year' => $this->faker->year,
            'barcode' => $this->faker->unique()->isbn13,
            'stock' => $this->faker->numberBetween(1, 10),
            'shelf_location' => 'Rak ' . $this->faker->randomDigit,
            'category' => 'Umum'
        ];
    }
}
