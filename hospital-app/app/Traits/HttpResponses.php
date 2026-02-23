<?php

namespace App\Traits;

trait HttpResponses {
    // the success response
    protected function success($data, $message = null, $code = 200) {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    // the error response
    protected function error($message, $code = 400, $data = null) {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
