<?php

namespace App\Http\Services;

use App\Models\Advertisement;
use App\Models\Assessment;

class AdvertisementReviewRatingService
{
    public function recalculateAdvertisement(int $advertisementId): void
    {
        $names = [ 'price_quality', 'timeliness_of_the_meeting', 'purity', 'photo_match', 'convenience_of_location'];
        $avgs = [];
        $avgs['average_rating'] = Assessment::where('advertisement_id', $advertisementId)->active()->avg('average_rating');
        foreach ($names as $name) {
            $avgs['average_' . $name] = Assessment::where('advertisement_id', $advertisementId)->active()->avg($name);
        }
        $avgs['assessments_count'] = Assessment::where('advertisement_id', $advertisementId)->active()->count();
        Advertisement::where('id', $advertisementId)->update($avgs);
    }

    public function recalculateReview(array $data): float
    {
        return number_format(($data['price_quality'] + $data['timeliness_of_the_meeting'] +
                $data['purity'] + $data['photo_match'] + $data['convenience_of_location']) / 5, 1);
    }
}
