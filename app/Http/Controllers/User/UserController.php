<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


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
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            if($e instanceof ModelNotFoundException) {
                return response()->json(['error' => 'Record not found'], 404);
            }
        }
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (Exception $e) {
            if($e instanceof ModelNotFoundException) {
                return response()->json(['error' => 'Record not found'], 404);
            }
        }
        return $this->showOne($user);
    }
}
