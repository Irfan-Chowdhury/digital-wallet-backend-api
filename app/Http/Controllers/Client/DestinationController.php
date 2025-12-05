<?php

namespace App\Http\Controllers\Client;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Destination;
// use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function popular()
    {

        $destinations = Destination::select('id', 'name', 'country', 'image_url AS image', 'active_travelers as activeTravelers')
                ->orderBy('active_travelers', 'desc')->get();

        return ApiResponse::success(
            "Popular destinations fetched successfully!",
            $destinations
        );
    }

}
