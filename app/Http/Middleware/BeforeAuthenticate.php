<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuthToken;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;


class BeforeAuthenticate
{
    protected $auth = null;
    protected $token = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        $this->auth = null;
        $this->token = $this->request->header('Authorization');
    }

    public function handle($request, Closure $next)
    {
        $error = $this->error;

        if (!!$this->token) {
            $this->auth = AuthToken::where('token', $this->token)->first();

            if (!!$this->auth) {
                $authToken = AuthToken::where('token', $this->token)->first();
                if (!$authToken->isRemembered() && $authToken->isExpired()) {
                    return response()->json(array(
                        'errors' => array(
                            array(
                                'errorMessages' => $error['tokens_expired'],
                                'errorCode' => $error['ApiErrorCodes']['tokens_expired']
                            )
                        )
                    ), 401);
                } else {
                    // TODO token is valid
                    $authToken->extend();
                    // put auth token to request
                    $request->attributes->add(array(
                        'authToken' => $authToken
                    ));

                    //session timezone
                    Session::put('timezone', (int)$authToken->timezone);

                    return $next($request);
                }
            } else {
                return response()->json(array(
                    'errors' => array(
                        array(
                            'errorMessages' => $error['unauthorized'],
                            'errorCode' => $error['ApiErrorCodes']['unauthorized']
                        )
                    )
                ), 401);
            }
        }else {
            return $next($request);
        }
    }
}
