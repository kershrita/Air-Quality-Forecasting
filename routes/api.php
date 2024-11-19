<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ClubBookingController;
use App\Http\Controllers\Api\CropController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\OTPController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReviewController;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('lang')->group(function () {

    Route::get('/cities', function (Request $request) {
        $stateId = $request->get('state_id');

        // Validate the state_id
        if (!$stateId) {
            return response()->json(['error' => 'State ID is required'], 400);
        }

        // Fetch unique city names grouped by 'name'
        $cities = City::where('state_id', $stateId)
            ->select( 'name') // Select relevant fields
            ->groupBy('name') // Group by city name
            ->distinct() // Ensure unique values
            ->get();

        return response()->json($cities);
    });

});
