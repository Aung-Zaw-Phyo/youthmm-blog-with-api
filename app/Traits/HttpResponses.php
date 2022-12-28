<?php

namespace App\Traits;

use Illuminate\Support\Facades\Request;

trait HttpResponses {

    protected function success ($data, $message, $code = 201) {
        if ( Request::ajax() ) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data
            ]);
        }else {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data
            ], $code);
        }
    }

    protected function error ($data, $message, $code) {
        if ( Request::ajax() ) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => $data
            ]);
        }else {
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => $data
            ], $code);
        }
    }
}
