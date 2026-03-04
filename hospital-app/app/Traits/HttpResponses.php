<?php

namespace App\Traits;

trait HttpResponses {
    // the success response
    public function success($data = null, $message = 'Operation successful', $code = 200) {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    // the error response
    public function error($data = null, $message = 'An error occurred', $code = 400) {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
