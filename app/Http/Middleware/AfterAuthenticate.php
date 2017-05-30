<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\AuthToken;

class AfterAuthenticate
{
    private $auth;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');

        $this->auth = null;
        $this->token = $this->request->header('Authorization');

        if (!!$this->token) {
            $this->auth = AuthToken::where('token', $this->token);
        }
    }

    public function handle($request, Closure $next)
    {
        if (!empty($this->auth)) {

            $authToken = AuthToken::where('token', $this->token)->first();

            $authToken->extend();

            return $next($request);
        }
        return $next($request);
    }
}
