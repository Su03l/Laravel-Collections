<?php

namespace App\Traits;

trait ApiResponse {

    // for success
    public function success($data = null, $message = 'Operation successful', $code = 200) {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($data = null, $message = 'An error occurred', $code = 400) {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $data
        ], $code);
    }
}
