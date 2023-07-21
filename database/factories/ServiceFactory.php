<?php

namespace Database\Factories;

use Domain\Service\Helpers\ServiceStatus;
use Domain\Service\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(100),
            'customer_id' => CustomerFactory::new()->create()->id,
            'status' => ServiceStatus::Pending,
        ];
    }
}
