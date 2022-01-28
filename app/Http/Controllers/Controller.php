<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function paginate()
    {
        return env('API_PAGINATE');
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function send(string $message, array $data, int $status): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data,
            ],
            $status
        );
    }

    /**
     * @return JsonResponse
     */
    protected function notFound(): JsonResponse
    {
        return response()->json(
            [
                'message' => __('not_found'),
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    /**
     * @return JsonResponse
     */
    protected function internalError(): JsonResponse
    {
        return response()->json(
            [
                'message' => __('internal.error'),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    /**
     * @return JsonResponse
     */
    protected function unAuthorized(): JsonResponse
    {
        return response()->json(
            [
                'message' => __('unauthorized'),
            ],
            Response::HTTP_UNAUTHORIZED,
        );
    }
}
