<?php

namespace Tests\Feature\Customer;

use Database\Factories\CustomerFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerSearchTest extends TestCase
{
    private $knownData = [
        ['business_name' => 'Zentcode Inc.', 'document_number' => '123456-1'],
        ['business_name' => 'Company A Inc.', 'document_number' => '1234567-2'],
        ['business_name' => 'Test Corporate', 'document_number' => '12345678-3'],
        ['business_name' => 'My Company A', 'document_number' => '65432-2'],
        ['business_name' => 'My Company B', 'document_number' => '6543-3'],
    ];

    /** @test */
    public function search_return_limited_customers()
    {
        CustomerFactory::new()->count(25)->create();
        $this->login();

        $response = $this->getJson(route('customers.search'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function(AssertableJson $json) {
                $json
                    ->has('data', 5) //5 data because of limit
                    ->has('data.0', function(AssertableJson $json) {
                        $json->whereAllType([
                            'id'=> 'integer',
                            'business_name' => 'string',
                            'document_number' => 'string',
                        ]);
                    });
            });
    }

    /** @test */
    public function search_return_filtered_customers_by_business_name()
    {
        CustomerFactory::new()->count(5)
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('customers.search', ['search' => 'Inc']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

    /** @test */
    public function search_return_filtered_customers_by_document_number()
    {
        CustomerFactory::new()->count(5)
            ->sequence(...$this->knownData)
            ->create();

        $this->login();

        $response = $this->getJson(route('customers.search', ['search' => '123']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 3)->etc());
    }

}
