<?php

namespace Tests\Feature\Customer;

use Database\Factories\CustomerFactory;
use Domain\Customer\Models\Customer;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexCustomerTest extends TestCase
{
    private $knownData = [
        ['business_name' => 'Zentcode Inc.', 'document_number' => '123456-1', 'contact_name' => 'Jon Doe'],
        ['business_name' => 'Company A Inc.', 'document_number' => '1234567-2', 'contact_name' => 'Jane Doe'],
        ['business_name' => 'Test Corporate', 'document_number' => '12345678-3', 'contact_name' => 'Carla Doe'],
        ['business_name' => 'My Company A', 'document_number' => '65432-2', 'contact_name' => 'Doctor X.'],
        ['business_name' => 'My Company B', 'document_number' => '6543-3', 'contact_name' => 'Doctor Doe'],
    ];

    /** @test */
    public function index_return_paginated_customers()
    {
        CustomerFactory::new()->count(25)->create();
        $this->login();

        $response = $this->getJson(route('customers.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function(AssertableJson $json) {
                $json
                    ->has('data', 20) //20 data because of pagination
                    ->has('meta')
                    ->has('links')
                    ->has('data.0', function(AssertableJson $json) {
                        $json->whereAllType([
                            'id'=> 'integer',
                            'business_name' => 'string',
                            'document_number' => 'string',
                            'contact_name' => 'string',
                            'phone_number' => 'string',
                            'email' => 'string',
                            'address' => 'string',
                        ]);
                    });
            });
    }

    /** @test */
    public function index_return_filtered_customers_by_business_name()
    {
        CustomerFactory::new()->count(5)
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('customers.index', ['search' => 'Inc']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

    /** @test */
    public function index_return_filtered_customers_by_document_number()
    {
        CustomerFactory::new()->count(5)
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('customers.index', ['search' => '123']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 3)->etc());
    }

    /** @test */
    public function index_return_filtered_customers_by_contact_name()
    {
        CustomerFactory::new()->count(5)
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('customers.index', ['search' => 'Doe']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 4)->etc());
    }
}
