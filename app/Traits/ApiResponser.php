<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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
     * Display an array of success responses.
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

        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        //$collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        //$collection = $this->cachedResponse($collection);
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
     * Display a success response.
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
     * Display an array of transformed data.
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
     * Filter data based on query params.
     *
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function filterData(Collection $collection, $transformer): Collection
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);
            if(isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }

    /**
     * Display response based on the provided query parameter.
     *
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function sortData(Collection $collection, $transformer): Collection
    {
        if(request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy($attribute);
        }
        return $collection;
    }

    /**
     * Paginate collection based on page numbers.
     *
     * @param Collection $collection
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $collection): LengthAwarePaginator
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        Validator::validate(request()->all(), $rules);
       $page = LengthAwarePaginator::resolveCurrentPage();
       $perPage = 15;
       if(request()->has('per_page')) {
           $perPage = (int) request()->per_page;
       }
       $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
       $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
           'path' => LengthAwarePaginator::resolveCurrentPath(),
       ]);
       $paginated->appends(request()->all());
       return $paginated;

    }

    /**
     * Cache response for 5 minutes.
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function cachedResponse(Collection $collection): Collection
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";
        return Cache::remember($fullUrl, 300, function () use($collection) {
            return $collection;
        });
    }
}

