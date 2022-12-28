<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function deleteUser($userId);

    public function banUser ($request, $userId);

    public function cancelBanUser ($userId);

    public function getAllSubscribers ();

    public function deleteSubscriber ($subscriberId);

}
