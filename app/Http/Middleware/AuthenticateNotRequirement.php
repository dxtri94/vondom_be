<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuthToken;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;


class AuthenticateNotRequirement
{
    protected $auth = null;
    protected $token = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        $this->auth = null;
        $this->token = $this->request->header('Authorization');

        if (!!$this->token) {
            $this->auth = AuthToken::where('token', $this->token)->first();
        }
    }

    public function handle($request, Closure $next)
    {
        if (!!$this->auth) {
            $authToken = AuthToken::where('token', $this->token)->first();
            if (!$authToken->isRemembered() && $authToken->isExpired()) {
                $request->attributes->add(array(
                    'authToken' => null
                ));
            } else {
                // put auth token to request
                $request->attributes->add(array(
                    'authToken' => $authToken
                ));

                // extend expired token
                $authToken->extend();

                //session timezone
                Session::put('timezone', (int)$authToken->timezone);
            }
            return $next($request);
        } else {
            $request->attributes->add(array(
                'authToken' => null
            ));
            return $next($request);
        }
    }
}
