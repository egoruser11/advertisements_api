<?php

namespace App\Http\Controllers;


use App\Http\Requests\Reservation\CancelRequest;
use App\Http\Requests\Reservation\FilterRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Services\ReservationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class ReservationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(private ReservationService $reservationService)
    {

    }

    public function index(FilterRequest $request): JsonResponse
    {
        $reservations = $this->reservationService->filter($request->validated(), Auth::id());

        return response_success(['reservations' => ReservationResource::collection($reservations)]);
    }

    public function cancel(CancelRequest $request): JsonResponse
    {
        $this->reservationService->cancel($request->validated(), Auth::id());

        return response_success();
    }
}
