<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\EndRegisterUserRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\FileAdvertisement;
use App\Models\PhotoUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function update(UpdateRequest $request): JsonResponse
    {
        User::where('id',Auth::id())->update($request->validated());
        return response_success();
    }

    public function storeFile(UploadedFile $file)
    {
        $filename = $file->store('users_photos');
        return $filename;
    }

    public function addPhoto(Request $request)//: JsonResponse
    {
        $filename = $this->storeFile($request->photo);
        PhotoUser::create(['name' => $filename, 'user_id' => $request->user_id]);
        return response_success(['file' => $filename]);
    }

    public function deletePhoto(Request $request)//: JsonResponse
    {
        $file = PhotoUser::findOrFail($request->photoId);
        $filePath = $file->name;
        Storage::delete($filePath);
        $file->delete();

        return response_success(['file' => $filePath]);
    }
}
