<?php

namespace App\Traits;

trait Response{

    public function success($is_error, $message, $data, $status = 200){
       return response()->json([
        'error' => $is_error,
        'message' => $message,
        'data' => $data
       ], $status);
    }

    public function error($is_error, $message, $status = 400){
        return response()->json([
            'error' => $is_error,
            'message' => $message,
           ], $status);
    }
}
