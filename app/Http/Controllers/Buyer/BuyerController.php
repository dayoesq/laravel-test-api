<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;


class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
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
            $buyer = Buyer::has('transactions')->findOrFail($id);
        } catch (Exception $e) {
            if($e instanceof ModelNotFoundException) {
                return response()->json(['error' => 'The requested resource could not be found'], 404);
            }
        }
        return $this->showOne($buyer);
    }


}
