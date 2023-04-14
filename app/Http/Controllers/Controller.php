<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data, $code = 200)
    {
        $response = [];
        $response['data'] = ($code == 200) ? $data : null;

        $response['message'] = ($code == 200) ? null : $data['message'] ?? 'Request failed';
        $response['http_code'] = $code;
        $response['status'] = ($code == 200) ? 'success' : 'failed';
        $response['error'] = ($code == 200) ? null : $data;


        return response()->json($response, $code);
    }
}
