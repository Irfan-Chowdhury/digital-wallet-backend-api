<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    public function getAvailableServices()
    {
        return Service::where('status', true)->get();
    }

    public function createService(array $data): Service
    {
        return Service::create($data);
    }

    public function updateService(int $id, array $data): Service
    {
        $service = Service::findOrFail($id);
        $service->update($data);

        return $service;
    }

    public function deleteService(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->delete();
    }
}
