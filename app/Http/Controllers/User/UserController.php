<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;



class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return $this->showOne($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return $this->showOne($user);
    }
}
