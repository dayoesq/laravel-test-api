<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse(array $data, int $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function errorResponse(string | array $message, int $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, int $code = 200): JsonResponse
    {
        if($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;
        $collection = $this->transformData($collection, $transformer);
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $model, int $code = 200): JsonResponse
    {
        $transformer = $model->transformer;
        $model = $this->transformData($model, $transformer);
        return $this->successResponse($model, $code);
    }

    protected function showMessage($message, int $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData(Collection | Model $data, $transformer): array
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }
}

