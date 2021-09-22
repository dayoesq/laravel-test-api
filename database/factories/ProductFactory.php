<?php

namespace Database\Factories;


use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'quantity' => "int", 'status' => "mixed", 'image' => "mixed", 'seller_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
            'image' => $this->faker->randomElement(['image-1.jpg', 'image-2.jpg', 'image-3.jpg']),
            'seller_id' => User::all()->random()->id
        ];
    }
}
