<?php

namespace Tests\Feature\Service;

use Database\Factories\ServiceFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceIndexTest extends TestCase
{
    private $knownData = [
        ['name' => 'Service 1'],
        ['name' => 'Test Service'],
        ['name' => 'Test'],
    ];

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
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('services.index', ['search' => 'Test']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

}
