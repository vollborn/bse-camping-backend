<?php

namespace App\Middlewares;

use App\Classes\Auth;
use App\Classes\DB;
use App\Classes\Response;
use Exception;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthMiddleware implements IMiddleware
{
    /**
     * @throws Exception
     */
    public function handle(Request $request): void
    {
        $header = $request->getHeader('HTTP_AUTHORIZATION');

        if (!$header) {
            $this->setCallback($request);
            return;
        }

        if (!str_starts_with($header, 'Bearer ')) {
            $this->setCallback($request);
            return;
        }

        $token = substr($header, 7);

        $user = DB::fetch('SELECT * FROM users WHERE api_token = :api_token', [
            'api_token' => $token
        ]);

        if (!$user) {
            $this->setCallback($request);
            return;
        }

        Auth::setUserData($user);
    }

    private function setCallback(Request $request): void
    {
        $request->setRewriteCallback(static function () {
            return Response::create([], 403);
        });
    }
}