<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Domain\Customer\Actions\CreateCustomerAction;
use Domain\Customer\Actions\UpdateCustomerAction;
use Domain\Customer\DataTransferObjects\CustomerData;
use Domain\Customer\Models\Customer;
use Domain\Customer\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CustomerController extends Controller
{
    public function store(CustomerData $customerData, CreateCustomerAction $createCustomerAction): JsonResponse
    {
        $createCustomerAction($customerData);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(Customer $customer): CustomerResource
    {
        return CustomerResource::make($customer);
    }

    public function update(Customer $customer, CustomerData $customerData, UpdateCustomerAction $updateCustomerAction): JsonResponse
    {
        $updateCustomerAction($customer, $customerData);

        return response()->json([], Response::HTTP_OK);
    }

}
