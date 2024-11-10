<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ok($data, $code = 200)
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }

        return response()->json($data, $code);
    }

    public function fail($data, $code = 403)
    {
        return $this->ok($data, $code);
    }
}
