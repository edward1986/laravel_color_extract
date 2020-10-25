<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;
    private $number = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->number++;

        return [
            'name' => 'テスト商品名 - '. $this->number,
            'description' => "テスト説明文\nテスト説明文\nテスト説明文 - ". $this->number,
            'price' => $this->faker->randomDigitNotNull() * 1000
        ];
    }
}
