<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advertisement\AddAssessmentRequest;
use App\Http\Requests\Advertisement\FilterRequest;
use App\Http\Requests\Advertisement\FilterTwoRequest;
use App\Http\Requests\Advertisement\ReservationFilterRequest;
use App\Http\Requests\Advertisement\UpdateAssessmentRequest;
use App\Http\Resources\AdvertisementResource;
use App\Http\Services\AdvertisementFilterService;
use App\Http\Services\AdvertisementReviewRatingService;
use App\Http\Services\AdvertisementService;
use App\Models\Advertisement;
use App\Models\Assessment;
use App\Models\Condition;
use App\Models\FileAdvertisement;
use App\Models\Reason;
use App\Models\RuleOfReservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends BaseController
{
    public function __construct(private AdvertisementReviewRatingService $advertisementReviewRatingService, private AdvertisementService $advertisementService)
    {

    }


    public function index(FilterRequest $request, AdvertisementFilterService $advertisementFilterService): JsonResponse
    {
        $advertisements = $advertisementFilterService->run($request->validated());

        return response_success(['advertisements' => AdvertisementResource::collection($advertisements)]);
    }

    public function store(Request $request)//: JsonResponse
    {
        $advertisement = Advertisement::create([
            'address' => $request->address,
            'rooms_count' => $request->rooms_count,
        ]);
        $data = $request->json()->all();
        $advertisement->load('params');
        $params = [];
        foreach ($data as $param) {
            foreach ($param as $value) {
                $params[$value['id']] = ['value' => $value['value']];
            }
        }
        $advertisement->params()->attach($params);
        return response_success(['advertisement' => $advertisement->load('params')]);
    }

    public function update(Request $request)//: JsonResponse
    {

        Advertisement::where('id', $request->id)->update($request->except('params', 'id'));
        $advertisement = Advertisement::findOrFail($request->id);
        $data = $request->json()->all();
        $params = [];
        foreach ($data as $param) {
            foreach ($param as $value) {
                $params[$value['id']] = ['value' => $value['value']];
            }
        }
        $advertisement->params()->sync($params);
        $advertisement->load('params');
        return response_success(['advertisement' => $advertisement]);
    }

    public function show(Request $request)//: JsonResponse
    {
        $advertisement = Advertisement::with('params', 'condition', 'assessements', 'guests')->findOrFail($request->id);
        $condition = Condition::where('advertisement_id', $request->id)->first();
        $rulesOfReservation = RuleOfReservation::where('condition_id', $condition->id)->get();
        return response_success(['advertisements' => $advertisement, 'rulesOfReservation' => $rulesOfReservation]);
    }

    public function booking(Request $request)
    {
        $reservation = $this->advertisementService->booking($request->except('guests'));
        return response_success(['reservation' => $reservation]);
    }

    public function addFavoriteAdvertisement(Request $request)//: JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $user->favoriteAdvertisements()->syncWithoutDetaching($request->advertisement_ids);
        return $user->load('favoriteAdvertisements');
    }

    public function addAssessment(AddAssessmentRequest $request)//: JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $assessment = $this->advertisementService->addAssessment($data);
        return response_success(['assessment' => $assessment]);
    }

    public function updateReview(UpdateAssessmentRequest $request)//: JsonResponse
    {
        $data = $request->validated();
        if (!empty($data['review'])) {
            $data['review'] = strip_tags($data['review']);
        }
        $assessment = Assessment::where('id', $request->id)->update($data);

        return response_success();
    }

    public function examinationAssessment(Request $request)//: JsonResponse
    {
        $assessment = Assessment::findOrFail($request->id);
        DB::transaction(function () use ($assessment, $request) {
            $assessment->update(['status' => $request->status]);
            if ($assessment->status == Assessment::STATUS_BLOCKED) {
                Reason::create(['assessment_id' => $request->assessment_id, 'user_id' => $request->user_id, 'reason' => $request->reason]);
            }
        });

        return response_success(['assessment' => $assessment]);
    }


    public function storeFile(UploadedFile $file): bool|string
    {
        return $file->store('advertisements_photos');
    }

    public function addPhoto(Request $request): JsonResponse
    {
        $filename = $this->storeFile($request->photo);
        FileAdvertisement::create(['name' => $filename, 'advertisement_id' => $request->advertisement_id]);
        return response_success();
    }

    public function deletePhoto(Request $request)//: JsonResponse
    {
        $file = FileAdvertisement::findOrFail($request->fileId);
        $filePath = $file->name;
        Storage::delete($filePath);
        $file->delete();
        return response_success(['file' => $filePath]);
    }


}
