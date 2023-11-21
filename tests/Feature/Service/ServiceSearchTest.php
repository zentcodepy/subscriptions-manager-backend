<?php

namespace Tests\Feature\Service;

use Database\Factories\ServiceFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceSearchTest extends TestCase
{
    /** @test */
    public function search_return_limited_services()
    {
        ServiceFactory::new()->count(25)->create();
        $this->login();

        $response = $this->getJson(route('services.search'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function(AssertableJson $json) {
                $json
                    ->has('data', 5) //5 data because of limit
                    ->has('data.0', function(AssertableJson $json) {
                        $json->whereAllType([
                            'id'=> 'integer',
                            'name' => 'string',
                            'customer_name' => 'string',
                        ]);
                    });
            });
    }

    /** @test */
    public function search_return_filtered_services_by_name()
    {
        ServiceFactory::new()->count(3)
            ->sequence(
                ['name' => 'Service 1'],
                ['name' => 'Test Service'],
                ['name' => 'Test'],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('services.search', ['search' => 'Test']));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }

}
