<?php

namespace App\Http\Controllers;


use App\Http\Requests\Assessment\ExaminateRequest;
use App\Http\Requests\Assessment\StoreRequest;
use App\Http\Requests\Assessment\UpdateRequest;
use App\Http\Services\AssessmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends BaseController
{
    public function __construct(private AssessmentService $assessmentService)
    {

    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $assessment = $this->assessmentService->store($data);
        return response_success(['assessment' => $assessment]);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $this->assessmentService->update($request->validated());

        return response_success();
    }

    public function examinate(ExaminateRequest $request): JsonResponse
    {
        $this->assessmentService->examinate($request->validated());

        return response_success();
    }


}
