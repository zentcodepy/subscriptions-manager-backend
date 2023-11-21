<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use Domain\Service\Actions\CreateServiceAction;
use Domain\Service\Actions\DeleteServiceAction;
use Domain\Service\Actions\UpdateServiceAction;
use Domain\Service\DataTransferObjects\ServiceCreateData;
use Domain\Service\DataTransferObjects\ServiceIndexFilterData;
use Domain\Service\DataTransferObjects\ServiceSearchFilterData;
use Domain\Service\DataTransferObjects\ServiceUpdateData;
use Domain\Service\Models\Service;
use Domain\Service\Resources\ServiceIndexResource;
use Domain\Service\Resources\ServiceSearchResource;
use Domain\Service\Resources\ServiceShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ServiceController extends Controller
{
    public function index(ServiceIndexFilterData $serviceIndexFilterData): AnonymousResourceCollection
    {
        $services = Service::query()
            ->with([
                'customer:id,business_name',
            ])
            ->whereCustomerId($serviceIndexFilterData->customerId)
            ->whereStatus($serviceIndexFilterData->status)
            ->whereLikeName($serviceIndexFilterData->name)
            ->paginate(20);

        return ServiceIndexResource::collection($services);
    }

    public function search(ServiceSearchFilterData $serviceSearchFilterData): AnonymousResourceCollection
    {
        $services = Service::query()
            ->with([
                'customer:id,business_name',
            ])
            ->select('id', 'customer_id', 'name')
            ->whereLikeName($serviceSearchFilterData->search)
            ->limit(5)
            ->get();

        return ServiceSearchResource::collection($services);
    }

    public function store(ServiceCreateData $serviceData, CreateServiceAction $createServiceAction): JsonResponse
    {
        $createServiceAction($serviceData);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(Service $service): ServiceShowResource
    {
        return ServiceShowResource::make($service);
    }

    public function update(Service $service, ServiceUpdateData $serviceData, UpdateServiceAction $updateServiceAction): JsonResponse
    {
        $updateServiceAction($service, $serviceData);

        return response()->json([], Response::HTTP_OK);
    }

    public function destroy(Service $service, DeleteServiceAction $deleteServiceAction): JsonResponse
    {
        $deleteServiceAction($service);

        return response()->json([], Response::HTTP_OK);
    }

}
