<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Domain\Customer\Actions\CreateCustomerAction;
use Domain\Customer\DataTransferObjects\CustomerData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CustomerController extends Controller
{
    public function store(Request $request, CreateCustomerAction $createCustomerAction)
    {
        $createCustomerAction(CustomerData::fromRequest($request));

        return response()->json([], Response::HTTP_CREATED);
    }
}
