<?php

namespace Tests\Feature\Customer;

use Database\Factories\CustomerFactory;
use Domain\Customer\Models\Customer;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerShowTest extends TestCase
{
    /** @test */
    public function can_get_customer_data_by_id()
    {
        $this->login();

        $customer = CustomerFactory::new()->create();

        $response = $this->getJson(route('customers.show', ['customer' => $customer->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($customer) {
                $json->has('data', function (AssertableJson $json) use ($customer) {
                    $json->whereAllType([
                        'id'=> 'integer',
                        'business_name' => 'string',
                        'document_number' => 'string',
                        'contact_name' => 'string',
                        'phone_number' => 'string',
                        'email' => 'string',
                        'address' => 'string',
                        'comments' => 'string',
                    ])
                    ->where('id', $customer->id);
                });
            });
    }
}
