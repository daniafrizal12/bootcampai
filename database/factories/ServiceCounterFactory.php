<?php

namespace Database\Factories;

use App\Models\ServiceCounter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceCounter>
 */
class ServiceCounterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<ServiceCounter>
     */
    protected $model = ServiceCounter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = 'CTR-' . fake()->unique()->numerify('##');

        return [
            'name' => 'Loket Pelayanan ' . fake()->numerify('#'),
            'code' => $code,
            'location' => 'Lantai ' . fake()->numberBetween(1, 3) . ' - Ruang ' . fake()->numberBetween(101, 305),
            'is_active' => true,
        ];
    }
}
