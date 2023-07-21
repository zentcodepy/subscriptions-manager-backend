<?php

namespace Tests\Feature\Service;

use Database\Factories\CustomerFactory;
use Database\Factories\ServiceFactory;
use Domain\Service\Helpers\ServiceStatus;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceUpdateTest extends TestCase
{
    /** @test */
    public function can_update_a_service()
    {
        $this->login();

        $service = ServiceFactory::new()->create();
        $customerB = CustomerFactory::new()->create();


        $response = $this->putJson(route('services.update', ['service' => $service->id]), [
            'name' => 'Hosting service',
            'customer_id' => $customerB->id,
            'status' => ServiceStatus::Inactive,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $service->refresh();

        echo $service->status;

        $this->assertTrue($service->name === 'Hosting service');
        $this->assertTrue($service->customer_id === $customerB->id);
        $this->assertTrue($service->status === ServiceStatus::Inactive->value);
    }

    /** @test */
    public function fields_are_validated_when_try_to_update_a_service()
    {
        $this->login();

        $service = ServiceFactory::new()->create();

        $response = $this->putJson(route('services.update', ['service' => $service->id]), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'customer_id', 'status']);
    }

}
