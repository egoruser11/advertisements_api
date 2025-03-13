<?php

namespace App\Http\Controllers;


use App\Http\Requests\Advertisement\FilterRequest;
use App\Http\Requests\Advertisement\ShowRequest;
use App\Http\Requests\Advertisement\StoreRequest;
use App\Http\Requests\Advertisement\UpdateRequest;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\UserResource;
use App\Http\Services\AdvertisementFilterService;
use App\Http\Services\AdvertisementService;
use App\Http\Services\AdvertisementStoreService;
use App\Http\Services\AdvertisementUpdateService;
use App\Models\Advertisement;
use App\Models\Condition;
use App\Models\FileAdvertisement;
use App\Models\RuleOfReservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends BaseController
{

    public function __construct(private AdvertisementService       $advertisementService,
                                private AdvertisementStoreService  $advertisementStoreService,
                                private AdvertisementUpdateService $advertisementUpdateService
    )
    {

    }


    public function index(FilterRequest $request, AdvertisementFilterService $advertisementFilterService): JsonResponse
    {
        $advertisements = $advertisementFilterService->run($request->validated());

        return response_success(['advertisements' => AdvertisementResource::collection($advertisements)]);
    }

    public function store(StoreRequest $request): Advertisement
    {
        return $this->advertisementStoreService->run($request->validated());
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $advertisement = $this->advertisementUpdateService->run($request->validated());
        return response_success(['advertisement' => $advertisement]);
    }

    public function show(ShowRequest $request): JsonResponse
    {
        $result = $this->advertisementService->show($request->validated());
        return response_success(['result' => $result]);
    }

    public function booking(Request $request): JsonResponse
    {
        $reservation = $this->advertisementService->booking($request->except('guests'));
        return response_success(['reservation' => $reservation]);
    }

    public function storeFavoriteAdvertisement(Request $request): JsonResponse
    {
        $user = $this->advertisementService->storeFavorite($request->validated(), auth()->user());
        return response_success(['user' => UserResource::make($user)]);
    }

    public function storeFile(UploadedFile $file): bool|string
    {
        return $file->store('advertisements_photos');
    }

    public function storePhoto(Request $request): JsonResponse
    {
        $filename = $this->storeFile($request->photo);
        FileAdvertisement::create(['name' => $filename, 'advertisement_id' => $request->advertisement_id]);
        return response_success();
    }

    public function deletePhoto(Request $request): JsonResponse
    {
        $file = FileAdvertisement::findOrFail($request->fileId);
        $filePath = $file->name;
        Storage::delete($filePath);
        $file->delete();
        return response_success(['file' => $filePath]);
    }


}
