<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Subscriber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    use HttpResponses;

    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function users () {
        return view('admin.users.users', [
            'users' => $this->UserRepository->getAllUsers()
        ]);
    }

    public function subscribers () {
        return view('admin.users.subscribers', [
            'subscribers' => $this->UserRepository->getAllSubscribers()
        ]);
    }

    public function banUser (Request $request) {

        return $this->UserRepository->banUser($request, $request->id);

        // $validator = Validator::make($request->all(), [
        //     'id' => ['required', Rule::exists('users', 'id')],
        //     'ban_date_limit' => ['required', 'integer']
        // ]);
        // if($validator->fails()){
        //     return $this->error(null, $validator->messages()->first(), 422);
        // }

        // try{
        //     $user = User::find($request->id);
        //     $user->ban_date_limit = $request->ban_date_limit;
        //     $user->save();
        //     return $this->success(null, 'Subscriber deleted successfully!', 200);
        // } catch (\Throwable $th) {
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }

    public function cancel_ban (Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => ['required', Rule::exists('users', 'id')]
        ]);

        if($validator->fails()){
            return $this->error(null, $validator->messages()->first(), 422);
        }

        return $this->UserRepository->cancelBanUser($request->id);

        // try{
        //     $user = User::find($request->id);
        //     $user->ban_date_limit = 0;
        //     $user->update();
        //     return $this->success(null, 'Cannelled ban user successfully!', 200);
        // } catch (\Throwable $th) {
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }

    public function delete_user (Request $request){
        $validator = Validator::make($request->all(), [
            'id' => ['required', Rule::exists('users', 'id')]
        ]);

        if($validator->fails()){
            return $this->error(null, $validator->messages()->first(), 422);
        }

        return $this->UserRepository->deleteUser($request->id);

        // try{
        //     $user = User::find($request->id);
        //     $user->visible = false;
        //     $user->update();
        //     return $this->success(null, 'Subscriber deleted successfully!', 200);
        // } catch (\Throwable $th) {
        //     return $this->error(null, 'Server Error!', 500);
        // }
    }


    public function delete_subscriber (Request $in) {
        try{
            $subscriber = Subscriber::find($in->id);
            $subscriber->visible = false;
            $subscriber->update();
            return $this->success(null, 'Subscriber deleted successfully!');
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }
}
