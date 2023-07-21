<?php

namespace Tests\Feature\Service;

use Database\Factories\CustomerFactory;
use Domain\Service\Helpers\ServiceStatus;
use Domain\Service\Models\Service;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceStoreTest extends TestCase
{
    /** @test */
    public function can_create_service()
    {
        $customer = CustomerFactory::new()->create();

        $this->login();

        $response = $this->postJson(route('services.store'), [
            'name' => 'Hosting service for Project X',
            'customer_id' => $customer->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue(Service::query()
            ->where('name', 'Hosting service for Project X')
            ->where('customer_id', $customer->id)
            ->where('status', ServiceStatus::Pending)
            ->exists());
    }

    /** @test */
    public function fields_are_validated_when_try_to_create_a_service()
    {
        $this->login();

        $response = $this->postJson(route('services.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'customer_id'])
            ->assertJsonMissingValidationErrors(['status']);
    }
}
