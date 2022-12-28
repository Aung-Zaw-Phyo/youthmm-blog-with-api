<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriberResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    use HttpResponses;

    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function users () {
        return $this->success(UserResource::collection($this->UserRepository->getAllUsers()), 'Get all users!', 200);
    }

    public function banUser (Request $request, $id) {
        return $this->UserRepository->banUser($request, $id);
    }

    public function cancel_ban ($id) {
        return $this->UserRepository->cancelBanUser($id);
    }

    public function delete_user ($id) {
        return $this->UserRepository->deleteUser($id);
    }

    public function subscribers () {
        return $this->success(SubscriberResource::collection($this->UserRepository->getAllSubscribers()), 'get all subscribers!', 200);
    }

    public function delete_subscriber ($id) {
        return $this->UserRepository->deleteSubscriber($id);
    }

}
