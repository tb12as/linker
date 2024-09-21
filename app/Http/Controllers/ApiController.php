<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function json($response, $status_code = 200)
    {
        return response()
            ->json(
                $this->forceToArray($response),
                $status_code
            );
    }

    public function notFound($message = 'Not Found')
    {
        return $this->json([
            'message' => $message,
        ], 404);
    }

    public function success($message = 'Success!', $data = null, $showMessage = false)
    {
        return $this->json([
            'message' => $message,
            'show_message' => $showMessage,
            'data' => $data,
        ]);
    }

    public function fail($message = 'Opps, something went wrong', $data = null, $code = 403)
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    private function forceToArray($data)
    {
        if (is_string($data)) {
            return ['message' => $data];
        }

        return $data;
    }
}
