<?php

namespace Tests\Feature\Service;

use Database\Factories\ServiceFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceShowTest extends TestCase
{
    /** @test */
    public function can_get_service_data_by_id()
    {
        $this->login();

        $service = ServiceFactory::new()->create();

        $response = $this->getJson(route('services.show', ['service' => $service->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($service) {
                $json->has('data', function (AssertableJson $json) use ($service) {
                    $json->whereAllType([
                        'id'=> 'integer',
                        'name' => 'string',
                        'customer_id' => 'integer',
                        'customer_name' => 'string',
                        'status' => 'string',
                    ])
                    ->where('id', $service->id);
                });
            });
    }
}
