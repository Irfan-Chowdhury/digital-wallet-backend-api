<?php

namespace App\Http\Controllers\Client;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TravelerController extends Controller
{
    public function topRated()
    {
        $travelers = User::with('interests')
            ->orderBy('rating_avg', 'desc')
            ->limit(6)
            ->get();

        return ApiResponse::success(
            "Top-rated travelers fetched successfully!",
            $travelers
        );
    }
}
