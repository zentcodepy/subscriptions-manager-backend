<?php

namespace Tests\Feature\Service;

use Database\Factories\CustomerFactory;
use Database\Factories\ServiceFactory;
use Domain\Service\Helpers\ServiceStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceIndexTest extends TestCase
{
    /** @test */
    public function index_return_paginated_services()
    {
        ServiceFactory::new()->count(25)->create();
        $this->login();

        $response = $this->getJson(route('services.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function(AssertableJson $json) {
                $json
                    ->has('data', 20) //20 data because of pagination
                    ->has('meta')
                    ->has('links')
                    ->has('data.0', function(AssertableJson $json) {
                        $json->whereAllType([
                            'id'=> 'integer',
                            'name' => 'string',
                            'customer_name' => 'string',
                            'status' => 'string',
                        ]);
                    });
            });
    }

    /** @test */
    public function index_return_filtered_services_by_name()
    {
        ServiceFactory::new()->count(3)
            ->sequence(
                ['name' => 'Service 1'],
                ['name' => 'Test Service'],
                ['name' => 'Test'],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('services.index', ['name' => 'Test']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

    /** @test */
    public function index_return_filtered_services_by_status()
    {
        ServiceFactory::new()->count(4)
            ->sequence(
                ['status' => ServiceStatus::Active],
                ['status' => ServiceStatus::Active],
                ['status' => ServiceStatus::Pending],
                ['status' => ServiceStatus::Inactive],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('services.index', ['status' => ServiceStatus::Active]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

    /** @test */
    public function index_return_filtered_services_by_customer_id()
    {
        [$customer1, $customer2] = CustomerFactory::new()->count(2)->create();

        ServiceFactory::new()->count(6)
            ->sequence(
                ['customer_id' => $customer1->id],
                ['customer_id' => $customer2->id],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('services.index', ['customer_id' => $customer2->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 3)->etc());
    }
}
