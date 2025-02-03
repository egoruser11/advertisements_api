<?php

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

function response_success(array $data = []): JsonResponse
{
    $data['success'] = true;
    return response()->json($data);
}

function date_to_db(?string $date): ?string
{
    if (empty($date)) {
        return $date;
    }
    return Carbon::parse($date)->toDateTimeString();
}
