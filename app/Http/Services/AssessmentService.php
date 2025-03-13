<?php


namespace App\Http\Services;

use App\Exceptions\CustomException;
use App\Http\Requests\Assessment\ExaminateRequest;
use App\Http\Requests\Assessment\UpdateRequest;
use App\Http\Services\AdvertisementReviewRatingService;
use App\Mail\AssessmentOwner;
use App\Models\Advertisement;
use App\Models\Assessment;
use App\Models\Reason;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AssessmentService
{

    public function __construct(private AdvertisementReviewRatingService $advertisementReviewRatingService)
    {

    }

    private function isReservationNotExist(array $data): bool
    {
        return (Reservation::where('user_id', $data['user_id'])->where('advertisement_id', $data['advertisement_id'])
            ->where('departure_date', '<=', now())->doesntExist());
    }

    public function store(array $data): Assessment
    {
        if ($this->isReservationNotExist($data)) {
            throw new CustomException('no rights');
        }
        if (!empty($data['review'])) {
            $data['review'] = strip_tags($data['review']);
        }
        $data['status'] = Assessment::STATUS_ACTIVE;
        $data['average_rating'] = $this->advertisementReviewRatingService->recalculateReview($data);

        return Assessment::create($data);
    }

    public function examinate(array $data): void
    {
        $assessment = Assessment::findOrFail($data['id']);
        DB::transaction(function () use ($assessment, $data) {
            $assessment->update(['status' => $data['status']]);
            if ($assessment->is_blocked) {
                Reason::create(['assessment_id' => $data['id'], 'user_id' => $data['user_id'], 'reason' => $data['reason']]);
            } else if ($assessment->is_active) {
                $user = $assessment->advertisement->user;
                Mail::to($user)->send(new AssessmentOwner($assessment->advertisement, $user));
            }
        });
    }

    public function update(array $data): void
    {
        Assessment::where('id', $data['id'])->update($data);
    }
}


