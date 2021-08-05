<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Used to build json output
     * @param $data
     * @param int $status
     * @param array $header
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function buildJson($data, $status = 200, $header = array(), $options = 0)
    {
        $default_data = ['is_error' => false, 'msg' => ''];
        return \Response::json(array_merge($default_data, $data), $status, $header, $options);
    }
}
