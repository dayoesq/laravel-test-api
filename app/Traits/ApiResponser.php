<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /**
     * Display an array of prettified responses.
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    private function successResponse(array $data, int $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Display an array of prettified error responses.
     *
     * @param string|array $message
     * @param int $code
     * @return JsonResponse
     */
    protected function errorResponse(string | array $message, int $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Display a prettified success message.
     *
     * @param Collection $collection
     * @param int $code
     * @return JsonResponse
     */
    protected function showAll(Collection $collection, int $code = 200): JsonResponse
    {
        if($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $collection = $this->sortData($collection);
        $transformer = $collection->first()->transformer;
        $collection = $this->transformData($collection, $transformer);
        return $this->successResponse($collection, $code);
    }

    /**
     * Display a prettified response.
     *
     * @param Model $model
     * @param int $code
     * @return JsonResponse
     */
    protected function showOne(Model $model, int $code = 200): JsonResponse
    {
        $transformer = $model->transformer;
        $model = $this->transformData($model, $transformer);
        return $this->successResponse($model, $code);
    }

    /**
     * Display an array of prettified error responses.
     *
     * @param string|array $message
     * @param int $code
     * @return JsonResponse
     */
    protected function showMessage(array | string $message, int $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * Display an array of prettified error responses.
     *
     * @param Collection|Model $data
     * @param $transformer
     * @return array
     */
    protected function transformData(Collection | Model $data, $transformer): array
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }

    /**
     * Display response based on the provided query parameter.
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function sortData(Collection $collection): Collection
    {
        if(request()->has('sort_by')) {
            $attribute = request()->sort_by;
            $collection = $collection->sortBy($attribute);
        }
        return $collection;
    }
}

