<?php

namespace App\Traits;

trait ApiResponses
{

    protected function ok($message)
    {
        return $this->successResponse($message, 200);
    }

    /**
     * Generate a success response.
     *
     * @param  mixed  $data
     * @param  string|null  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = null, $statusCode = 200)
    {
        $response = [
            'success' => true,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Generate an error response.
     *
     * @param  string|null  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $statusCode = 500)
    {
        $response = [
            'success' => false,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }
}
