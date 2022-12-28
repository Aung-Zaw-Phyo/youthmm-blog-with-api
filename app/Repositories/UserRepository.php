<?php

namespace App\Repositories;

use App\Http\Resources\SubscriberResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Subscriber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface
{
    use HttpResponses;

    public function getAllUsers(){
        return User::where('visible', true)->latest()->paginate(10);
    }

    public function deleteUser($userId){
        try{
            $user = User::find($userId);
            if(!$user){
                return $this->error(null, 'User not found!', 403);
            }
            $user->visible = false;
            $user->update();
            return $this->success(new UserResource($user), 'User deleted successfully!', 200);
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function banUser ($request, $userId){
        $validator = Validator::make($request->all(), [
            'ban_date_limit' => ['required', 'integer']
        ]);
        if($validator->fails()){
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try{
            $user = User::find($userId);
            if(!$user){
                return $this->error(null, 'Not found!', 403);
            }
            $user->ban_date_limit = $request->ban_date_limit;
            $user->save();
            return $this->success(new UserResource($user), 'Ban user successfully!', 200);
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function cancelBanUser ($userId){
        try{
            $user = User::find($userId);
            if(!$user){
                return $this->error(null, 'Not found!', 403);
            }
            $user->ban_date_limit = 0;
            $user->update();
            return $this->success(new UserResource($user), 'Subscriber deleted successfully!', 200);
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public function getAllSubscribers (){
        return Subscriber::where('visible', true)->latest()->paginate(10);
    }

    public function deleteSubscriber ($subscriberId){
        try{
            $subscriber = Subscriber::find($subscriberId);
            if(!$subscriber){
                return $this->error(null, 'Subscriber not found!', 403);
            }
            $subscriber->visible = false;
            $subscriber->update();
            return $this->success(new SubscriberResource($subscriber), 'Subscriber deleted successfully!');
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    
    
}
