<?php


namespace App\Http\Services;


use App\Exceptions\CustomException;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordService
{
    public function sendEmail(array $data): void
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->setSecretCode();
        // todo send email
    }

    private function isSecretCodeExpired(Carbon $codeAt): bool
    {
        return ($codeAt->diffInMinutes(now()) > User::SECRET_CODE_RESEND_PERIOD_MAX);
    }

    private function validateSecretCode(User $user): void
    {
        if ($this->isSecretCodeExpired($user->secret_code_at)) {
            $user->update(['secret_code' => null, 'secret_code_at' => null]);
            throw new CustomException('please remember your try');
        }
    }

    public function resendEmail(array $data): void
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        if (!$user->secret_code) {
            $user->setSecretCode();
        }
        $this->validateSecretCode($user);

        $now = now();
        if ($user->secret_code_at->diffInMinutes($now) < User::SECRET_CODE_RESEND_PERIOD_MIN) {
            throw new CustomException("wait " . $now->diffInSeconds($user->secret_code_at) . " seconds");
        }
        // todo send email

    }

    public function changePassword(array $data): void
    {
        $user = User::where('email', $data['email'])->where('secret_code', $data['secret_code'])->firstOrFail();

        $this->validateSecretCode($user);

        $user->update([
            'password' => bcrypt($data['password']),
            'secret_code' => null,
            'secret_code_at' => null,
        ]);
    }
}
