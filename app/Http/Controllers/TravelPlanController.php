<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\TravelPlan\StoreTravelPlanRequest;
use App\Http\Requests\TravelPlan\UpdateTravelPlanRequest;
use App\Models\TravelPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TravelPlanController extends Controller
{
    // GET /api/travel-plans?page=1&user_id=123 (user_id optional)
    public function index(Request $request): JsonResponse
    {
        $query = TravelPlan::query()->orderBy('start_date', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        $plans = $query->paginate(10);

        return ApiResponse::success("Travel plans fetched successfully", $plans);
    }

    // POST /api/travel-plans
    public function store(StoreTravelPlanRequest $request): JsonResponse
    {
        $data = $request->validated();

        $plan = TravelPlan::create([
            'user_id'     => $data['user_id'],
            'destination' => $data['destination'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'budget'      => $data['budget'] ?? null,
            'travel_type' => $data['travel_type'] ?? null,
            'itinerary'   => $data['itinerary'] ?? null,
            'group_size'  => $data['group_size'] ?? 1,
            'status'      => $data['status'],
        ]);

        return ApiResponse::success("Travel plan created successfully", $plan, 201);
    }

    // GET /api/travel-plans/{id}
    public function show(TravelPlan $travelPlan): JsonResponse
    {
        return ApiResponse::success("Travel plan details", $travelPlan);
    }

    // PUT/PATCH /api/travel-plans/{id}
    public function update(UpdateTravelPlanRequest $request, TravelPlan $travelPlan): JsonResponse
    {
        $data = $request->validated();
        $travelPlan->update($data);

        return ApiResponse::success("Travel plan updated successfully", $travelPlan);
    }

    // DELETE /api/travel-plans/{id}
    public function destroy(TravelPlan $travelPlan): JsonResponse
    {
        $travelPlan->delete();

        return ApiResponse::success("Travel plan deleted successfully");
    }
}
