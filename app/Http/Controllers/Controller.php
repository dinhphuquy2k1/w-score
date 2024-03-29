<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param int $status
     * @param array $body
     * @return \Illuminate\Http\JsonResponse|object
     */
    protected function sendResponse(int $status, array $body = [])
    {
        $content = [
            'statusCode' => $status,
            'data' => $body,
        ];
        return response()->json($content)
            ->header('Content-Type', 'json')
            ->setStatusCode($status);
    }

    /**
     * @param array $body
     * @param string $message
     * @return \Illuminate\Http\JsonResponse|object
     */
    protected function sendResponseSuccess(array $body = [], string $message = '')
    {
        $content = [
            'statusCode' => Response::HTTP_OK,
            'message' => $message,
            'body' => $body,
        ];
        return response()->json($content)
            ->header('Content-Type', 'json')
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param array $body
     * @return \Illuminate\Http\JsonResponse|object
     */
    protected function sendResponseError(array $body = [])
    {
        $content = [
            'statusCode' => Response::HTTP_BAD_REQUEST,
            'data' => $body,
        ];
        return response()->json($content)
            ->header('Content-Type', 'json')
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

}
