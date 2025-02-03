<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\PasswordRequest;
use App\Http\Requests\Auth\SendEmailRequest;
use App\Http\Services\ResetPasswordService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ResetPasswordController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(private ResetPasswordService $resetPasswordService)
    {

    }

    public function sendEmail(SendEmailRequest $request): JsonResponse
    {
        $this->resetPasswordService->sendEmail($request->validated());
        return response_success();
    }

    public function resendEmail(SendEmailRequest $request): JsonResponse
    {
        $this->resetPasswordService->resendEmail($request->validated());
        return response_success();
    }

    public function changePassword(PasswordRequest $request): JsonResponse
    {
        $this->resetPasswordService->changePassword($request->validated());
        return response_success();
    }

}
