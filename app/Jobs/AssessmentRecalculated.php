<?php

namespace App\Jobs;

use App\Http\Services\AdvertisementReviewRatingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssessmentRecalculated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private int $advertisementId)
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AdvertisementReviewRatingService $advertisementReviewRatingService)
    {
        $advertisementReviewRatingService->recalculateAdvertisement($this->advertisementId);
    }
}
