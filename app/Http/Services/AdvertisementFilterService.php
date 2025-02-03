<?php


namespace App\Http\Services;

use App\Models\Advertisement;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AdvertisementFilterService
{

    private function whereFreePeriod(array $data, Builder $advertisements): Builder
    {
        if (!empty($data['arrival_date']) && !empty($data['departure_date'])) {
            $arrivalDate = Carbon::parse($data['arrival_date'])->toDateTimeString();
            $departureDate = Carbon::parse($data['departure_date'])->toDateTimeString();
            $advertisementsIds = Reservation::where(function ($query) use ($arrivalDate, $departureDate) {
                $query->where('arrival_date', '>=', $arrivalDate)->where('arrival_date', '<=', $departureDate);
            })->orWhere(function ($query) use ($arrivalDate, $departureDate) {
                $query->where('arrival_date', '<=', $arrivalDate)->where('departure_date', '>', $arrivalDate);
            })->where('departure_date', '>=', now())->pluck('advertisement_id');
            if (!empty($advertisementsIds)) {
                $advertisements->whereIntegerNotInRaw('id', $advertisementsIds);
            }
        }
        return $advertisements;
    }

    public function run(array $data): Collection
    {
        $advertisements = Advertisement::with('params');

        if (!empty($data['rooms_count'])) {
            $advertisements->whereIn('rooms_count', $data['rooms_count']);
        }

        if (!empty($data['params_ids'])) {
            foreach ($data['params_ids'] as $paramId) {
                $advertisements->whereHas('params', function ($query) use ($paramId) {
                    $query->where('id', $paramId);
                });
            }
        }
        if (!empty($data['max_cost'])) {
            $advertisements->where('price', '<=', $data['max_cost']);
        }
        if (!empty($data['min_cost'])) {
            $advertisements->where('price', '<=', $data['min_cost']);
        }

        if (!empty($data['city'])) {
            $advertisements->where('city', $data['city']);
        }

        if (!empty($data['guests_count'])) {
            $advertisements->where('guests_count', '>=', $data['guests_count']);
        }

        $advertisements = $this->whereFreePeriod($data, $advertisements);

        return $advertisements->limit($data['limit'] ?? 100)->offset($data['offset'] ?? 0)->
        orderBy($data['sort_field'] ?? 'created_at', $data['sort_dir'] ?? 'desc')->get();
    }

}


