<?php


namespace App\Http\Services;

use App\Exceptions\CustomException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    private function isNotValidCode(Carbon $codeAt): bool
    {
        return ($codeAt->diffInMinutes(now()) > USER::SECRET_CODE_RESEND_PERIOD_MAX
            || $codeAt->diffInMinutes(now()) < USER::SECRET_CODE_RESEND_PERIOD_MIN);
    }

    public function register(array $data): void
    {
        $data['phone_code'] = mt_rand(1000, 9999);
        $data['phone_code_at'] = now();
        $data['password'] = bcrypt(Str::random(20));
        $data['status'] = User::STATUS_WAIT;
        //todo отправить сгенерированный и добавленный код на номер из реквеста
        DB::transaction(function () use ($data) {
            $user = User::create($data);
            $user->assignRole(User::ROLE_SELLER);
        });
        //todo отправляем phone_code на email
    }

    public function login(array $data): array
    {
        //todo добавить проверку статуса
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new CustomException('invalid email or password');
        }
        return ['user' => $user, 'token' => $user->createToken('app')->plainTextToken];

    }

    public function verifyPhoneCode(array $data): void
    {
        $user = User::where('email', $data['email'])->firstOrFail();

        if ($user->status != User::STATUS_WAIT || empty($user->phone_code)) {
            throw new CustomException('cant verify');
        }
        if ($data['code'] != $user->phone_code) {
            throw new CustomException('invalid code');
        }
        if ($user->phone_code_at->diffInMinutes(now()) > 10) {
            $user->delete();
            throw new CustomException('time is out');
        }

        $user->update(['phone_code' => null, 'status' => User::STATUS_ACTIVE, 'phone_code_at' => null]);
    }

    public function resendPhoneCode(array $data): void
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        if (!$user->phone_code) {
            $user->update(['phone_code' => mt_rand(1000, 9999), 'phone_code_at' => now()]);
            // отправка
            return;
        }
        if ($this->isNotValidCode($user->phone_code_at)) {
            throw new CustomException('invalid code');
        }
        $user->update(['phone_code_at' => now()]);
        //отправление повторно
    }

}


