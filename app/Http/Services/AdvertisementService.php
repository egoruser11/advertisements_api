<?php


namespace App\Http\Services;

use App\Exceptions\CustomException;
use App\Http\Services\AdvertisementReviewRatingService;
use App\Models\Advertisement;
use App\Models\Assessment;
use App\Models\Reservation;
use Carbon\Carbon;


class AdvertisementService
{
    public function __construct(private AdvertisementReviewRatingService $advertisementReviewRatingService)
    {

    }

    public function booking(array $data): Reservation
    {
        $isReservations = Reservation::where('advertisement_id', $data['advertisement_id'])->where(function ($query) use ($data) {
            $query->where('arrival_date', '>=',
                Carbon::parse($data['arrival_date'])->toDateTimeString())->where('arrival_date', '<=', 'departure_date');
        })->orWhere(function ($query) use ($data) {
            $query->where('arrival_date', '<=', $data['arrival_date'])->where('departure_date', '>', $data['arrival_date']);
        })->where('status', '!=', Reservation::STATUS_CANCEL)->exists();

        if ($isReservations) {
            throw new CustomException();
        }

        $departure_date = Carbon::parse($data['departure_date']);
        $arrival_date = Carbon::parse($data['arrival_date']);
        $diffDays = $departure_date->diffInDays($arrival_date);
        $advertisement = Advertisement::findOrFaiL($data['advertisement_id']);

        $data['cost'] = $diffDays * $advertisement->price ?? 0;
        $data['status'] = Reservation::STATUS_WAITPAYED;

        return Reservation::create($data);

    }

    public function addAssessment(array $data)
    {
        if (Reservation::where('user_id', $data['user_id'])->where('advertisement_id', $data['advertisement_id'])->
        where('departure_date', '<=', now())->doesntExist()) {
            throw new CustomException('no rights');
        }
        if (!empty($data['review'])) {
            $data['review'] = strip_tags($data['review']);
        }
        $data['status'] = Assessment::STATUS_ACTIVE;
        $data['average_rating'] = $this->advertisementReviewRatingService->recalculateReview($data);
        return Assessment::create($data);
    }

    public function filter(array $data, $advertisements)
    {
        $roomsCount = $data['roomsCount'];
        $paramsIds = $data['paramsIds'];
        if (!empty($roomsCount)) {
            $advertisements->whereIn('rooms_count', $roomsCount);
        }
        if (!empty($paramsIds)) {
            foreach ($paramsIds as $paramId) {
                $advertisements->whereHas('params', function ($query) use ($paramId) {
                    $query->where('id', $paramId);
                });
            }
        }
        return $advertisements;

    }

}


