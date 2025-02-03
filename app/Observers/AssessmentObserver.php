<?php

namespace App\Observers;

use App\Http\Services\AdvertisementReviewRatingService;
use App\Models\Assessment;

class AssessmentObserver
{
    public function __construct(private AdvertisementReviewRatingService $advertisementReviewRatingService)
    {

    }

    public function created(Assessment $assessment)
    {
        if ($assessment->is_active) {
            $this->advertisementReviewRatingService->recalculateAdvertisement($assessment->advertisement_id);
        }
    }


    public function updated(Assessment $assessment)
    {
        $this->advertisementReviewRatingService->recalculateAdvertisement($assessment->advertisement_id);
    }


    public function deleted(Assessment $assessment)
    {
        if ($assessment->is_active) {
            $this->advertisementReviewRatingService->recalculateAdvertisement($assessment->advertisement_id);
        }
    }


}
