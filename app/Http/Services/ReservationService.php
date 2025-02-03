<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ReservationService
{
    public function filter(array $data, int $user_id): Collection
    {
        $reservations = Reservation::where('user_id', $user_id);
        if (!empty($data['city'])) {
            $reservations->whereHas('advertisement', function ($query) use ($data) {
                $query->where('city', $data['city']);
            });
        }
        if (!empty($data['arrival_date_min'])) {
            $arrival_date_min = date_to_db($data['arrival_date_min']);
            $reservations->where('arrival_date', '>=', $arrival_date_min);
        }
        if (!empty($data['arrival_date_max'])) {
            $arrival_date_max = date_to_db($data['arrival_date_max']);
            $reservations->where('arrival_date', '<=', $arrival_date_max);
        }
        if (!empty($data['departure_date_min'])) {
            $departure_date_min = date_to_db($data['departure_date_min']);
            $reservations->where('departure_date_min', '>=', $departure_date_min);
        }
        if (!empty($data['departure_date_max'])) {
            $departure_date_max = date_to_db($data['departure_date_max']);
            $reservations->where('departure_date_max', '<=', $departure_date_max);
        }
        if (!empty($data['status'])) {
            $reservations->where('status', $data['status']);
        }
        $reservations->limit($data['limit'])->offset($data['offset'])->orderBy('id', 'desc');
        return $reservations->get();
    }

    public function cancel(array $data, int $user_id)
    {
        $reservation = Reservation::findOrFail($data['id']);
        if ($reservation->user_id != $user_id) {
            throw new Exception('no rights');
        }
        if ($reservation->status == Reservation::STATUS_CANCEL) {
            throw new Exception('already cancel');
        }
        $reservation->update(['status' => Reservation::STATUS_CANCEL]);
    }

}
