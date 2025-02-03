<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\SendEmailRequest;
use App\Http\Requests\Auth\VerifyPhoneCodeRequest;
use App\Http\Services\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(private AuthService $authService)
    {

    }

    /**
     * Логин
     *
     * Пользователь не должен быть заблокированным
     *
     * @group Пользователь
     *
     * @bodyparam email string required Тест No-example
     * @response {
     * "success": true
     * }
     * @response {
     *     "success" : false
     * }
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        return response_success($this->authService->login($request->validated()));
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $this->authService->register($request->validated());

        return response_success();
    }

    public function verifyPhoneCode(VerifyPhoneCodeRequest $request): JsonResponse
    {
        $this->authService->verifyPhoneCode($request->validated());

        return response_success();
    }

    public function resendPhoneCode(SendEmailRequest $request): JsonResponse
    {
        $this->authService->resendPhoneCode($request->validated());
        return response_success();
    }
}
