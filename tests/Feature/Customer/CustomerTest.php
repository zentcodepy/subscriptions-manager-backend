<?php

namespace Tests\Feature\Customer;

use Database\Factories\CustomerFactory;
use Domain\Customer\Models\Customer;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    private array $knownData = [
        'business_name' => 'Zentcode',
        'document_number' => '123',
        'contact_name' => 'Jon Doe',
        'email' => 'test@email.com',
        'phone_number' => '123456',
        'address' => 'Zentcode Avenue',
        'comments' => 'This is a comment',
    ];

    /** @test */
    public function index_return_customers()
    {
        CustomerFactory::new()->count(20)->create();
        $this->login();

        $response = $this->getJson(route('customers.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function can_create_customer()
    {
        $this->login();

        $response = $this->postJson(route('customers.store'), $this->knownData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue(Customer::query()
            ->where('business_name', 'Zentcode')
            ->where('document_number', '123')
            ->where('contact_name', 'Jon Doe')
            ->where('email', 'test@email.com')
            ->where('phone_number', '123456')
            ->where('address', 'Zentcode Avenue')
            ->where('comments', 'This is a comment')
            ->exists());
    }

    /** @test */
    public function fields_are_validated_when_try_to_create_a_customer()
    {
        //$this->withoutExceptionHandling();

        $this->login();
        $data = ['email' => 'asd'];

        $response = $this->postJson(route('customers.store'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['business_name', 'email'])
            ->assertJsonMissingValidationErrors(['document_number', 'contact_name', 'phone_number', 'address', 'comments']);
    }

    /** @test */
    public function can_get_customer_data_by_id()
    {
        $this->login();

        [$customerA, $customerB] = CustomerFactory::new()->count(2)->create();

        $response = $this->getJson(route('customers.show', ['customer' => $customerA->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($customerA) {
                $json->has('data', function (AssertableJson $json) use ($customerA) {
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
                    ->where('id', $customerA->id);
                });
            });
    }

    /** @test */
    public function can_update_a_customer()
    {
        $this->login();

        $customer = CustomerFactory::new()->create();

        $response = $this->putJson(route('customers.update', ['customer' => $customer->id]), $this->knownData);

        $response->assertStatus(Response::HTTP_OK);
        $customer->refresh();

        $this->assertTrue($customer->business_name === 'Zentcode');
        $this->assertTrue($customer->document_number === '123');
        $this->assertTrue($customer->contact_name === 'Jon Doe');
        $this->assertTrue($customer->email === 'test@email.com');
        $this->assertTrue($customer->phone_number === '123456');
        $this->assertTrue($customer->address === 'Zentcode Avenue');
        $this->assertTrue($customer->comments === 'This is a comment');
    }

    /** @test */
    public function fields_are_validated_when_try_to_update_a_customer()
    {
        $this->login();

        $customer = CustomerFactory::new()->create();
        $data = ['email' => 'asd'];

        $response = $this->putJson(route('customers.update', ['customer' => $customer->id]), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['business_name', 'email'])
            ->assertJsonMissingValidationErrors(['document_number', 'contact_name', 'phone_number', 'address', 'comments']);
    }


}
