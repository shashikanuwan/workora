<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class FetchAuthenticateUserController extends Controller
{
    public function __invoke(UserRepository $userRepository): UserResource
    {
        return new UserResource($userRepository->getUser(request()->user()));
    }
}
