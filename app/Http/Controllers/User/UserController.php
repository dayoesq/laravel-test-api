<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Mail\UserCreated;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserController extends ApiController
{
    /**
     * Display a listing of the user resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created user resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $request->validated();
        $data = $request->all();
        try {
            $data['password'] = User::hash_password($data['password']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        $data['verified'] = User::UNVERIFIED_USER;
        try {
            $data['verification_token'] = User::generateRandomToken();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $user = User::create($data);

        return $this->showOne($user, 201);

    }

    /**
     * Update user resource.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, User $user): JsonResponse
    {
        /*$rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];*/

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateRandomToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = User::hash_password($request->password);
        }

        if ($request->has('admin')) {
            //$this->allowedAdminAction();

            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }

        if ($user->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Display user resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->showOne($user);
    }

    /**
     * Remove user resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->showOne($user);
    }

    /**
     * Verify user account with token.
     *
     * @param string $token
     * @return JsonResponse
     */
    public function verify(string $token): JsonResponse
    {
        $user = User::where('verification_token', $token)->findOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('Your account has been verified');
    }

    /**
     * Resend verification token.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function resend(User $user): JsonResponse
    {
        if($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }
        retry(5, function() use ($user){
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
        return $this->showMessage('A verification token has been sent to your email');
    }
}
