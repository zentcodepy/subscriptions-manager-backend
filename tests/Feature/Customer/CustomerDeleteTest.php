<?php

namespace Tests\Feature\Customer;

use Database\Factories\CustomerFactory;
use Domain\Customer\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerDeleteTest extends TestCase
{
    /** @test */
    public function can_delete_customer()
    {
        $this->login();

        [$customerA, $customerB] = CustomerFactory::new()->count(2)->create();

        $response = $this->deleteJson(route('customers.destroy', ['customer' => $customerA->id]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertTrue(Customer::query()->where('id', $customerA->id)->doesntExist());
        $this->assertTrue(Customer::query()->where('id', $customerB->id)->exists());
    }
}
