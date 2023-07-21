<?php

namespace Tests\Feature\Service;

use Database\Factories\ServiceFactory;
use Domain\Service\Models\Service;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServiceDeleteTest extends TestCase
{
    /** @test */
    public function can_delete_service()
    {
        $this->login();

        [$serviceA, $serviceB] = ServiceFactory::new()->count(2)->create();

        $response = $this->deleteJson(route('services.destroy', ['service' => $serviceA->id]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertTrue(Service::query()->where('id', $serviceA->id)->doesntExist());
        $this->assertTrue(Service::query()->where('id', $serviceB->id)->exists());
    }
}
