<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\AuthToken;
use App\Models\Bank;
use App\Models\Confirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/AdminAuth",
 *   description="Operation of Admin Authentication",
 *   produces="['application/json']"
 * )
 */
class AuthAdminController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Model(
     *  id="loginAdmin",
     * 	@SWG\Property(name="email", type="string", required=true, defaultValue="admin@mail.com"),
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue="123456"),
     * 	@SWG\Property(name="is_remember", type="boolean", required=true, defaultValue="false"),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/admin/login",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Login As Administrator",
     *      nickname="loginAdmin",
     *
     *      @SWG\Parameter(name="body", description="Request body", required=true, type="loginAdmin", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission denied | Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function login(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            $messages = array(
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'password.regex' => $error['ApiErrorCodes']['users_password_regex']
            );

            // validation
            $validatorError = User::validate($input, 'RULE_LOGIN', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // query user
            $user = User::where('email', $input['email'])->first();
            if (empty($user)) {
                return $this->notFound($error['users_email_invalid'], $error['ApiErrorCodes']['users_email_invalid']);
            }

            // permission admin
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // login
            $authToken = AuthToken::login($input['email'], $input['password'], $request->get('is_remember', false), $request->has('timezone', 0));
            if (empty($authToken)) {
                return $this->badRequest($error['users_password_incorrect'], $error['ApiErrorCodes']['users_password_incorrect']);
            }

            $authToken->user->role;

            return $this->success($authToken);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/admin/me",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Find Me As Admin",
     *      nickname="findAdminMe",
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function findMe(Request $request)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // detect role user
            if ($user->role === config('constants.ROLES.COMPANY')) {
                return $this->badRequest($error['users_access_denied'], $error['ApiErrorCodes']['users_access_denied']);
            }

            return $this->success($user);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="updateMe",
     * 	@SWG\Property(name="name", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="phone", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="address", type="string", required=true, defaultValue="")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/admin/me",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update Me As Admin",
     *      nickname="findMe",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="updateMe", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function updateMe(Request $request)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // validate
            $messages = array(
                'name.required' => $error['ApiErrorCodes']['users_name_required'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'address.required' => $error['ApiErrorCodes']['users_address_required']
            );
            $validatorError = User::validate($input, 'RULE_UPDATE_ADMIN', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            unset($input['password']);

            // detect email
            if ($user->email !== $request->get('email')) {
                $otherUser = User::where('email', $request->get('email'))
                    ->where('id', '<>', $user->id)
                    ->first();

                if ($otherUser) {
                    return $this->badRequest($error['users_email_unique'], $error['ApiErrorCodes']['users_email_unique']);
                }
            }

            // update to user
            $user->fill($input);
            $user->save();

            $user->role;

            return $this->success($user);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/admin/forgot",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Forgot password of Admin",
     *      nickname="forgotPassword",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="forgotPassword", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function forgot(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            // validation
            $messages = array(
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email']
            );
            $validatorError = User::validate($input, 'RULE_FORGOT_PASSWORD_USER', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // get user
            $user = User::where('email', $input['email'])->first();
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // permission admin
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // forgot password
            $token = $this->generateToken();
            $confirm = new Confirmation();
            $confirm->fill(array(
                'token' => $token,
                'user_id' => $user->id,
                'expired_at' => Carbon::now()->addHour(config('constants.LIVE_HOURS_TOKEN'))
            ));
            $confirm->save();

            // send message
            $this->sendEmailMessage('emails.auth.forgot', array(
                'user' => $user,
                'url' => config('constants.URLs.RESET_ADMIN') . "/" . $token
            ), config('constants.EMAILS.SUBJECTS.FORGOT_PASSWORD'), array(
                'email' => config('constants.EMAILS.EMAIL'),
                'name' => config('constants.EMAILS.NAME')
            ), array(
                'email' => $user->email,
                'name' => $user->name,
            ));

            return $this->accepted();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="confirmToken",
     * 	@SWG\Property(name="token", type="string", required=true, defaultValue=""),
     * )
     */
    /**
     *
     * @SWG\Api(
     *   path="/api/admin/confirm-token",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Check Token is expired",
     *      nickname="forgotPassword",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="confirmToken", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function confirm(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            $confirm = Confirmation::where('token', $input['token'])->first();
            if (empty($confirm)) {
                return $this->notFound($error['tokens_not_found'], $error['ApiErrorCodes']['tokens_not_found']);
            }

            //  check expired of token
            if ($this->isExpired($confirm->expired_at)) {
                return $this->badRequest($error['tokens_expired'], $error['ApiErrorCodes']['tokens_expired']);
            }

            return $this->accepted();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/admin/reset",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Reset Password of Admin User",
     *      nickname="resetPasswordAdmin",
     *
     *     	@SWG\Parameter(name="body", description="Request Body", required=true, type="resetPasswordUser", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function reset(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            // validate
            $message = array(
                'token.required' => $error['ApiErrorCodes']['confirm_tokens_token_required'],
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'password.alpha_num' => $error['ApiErrorCodes']['users_password_alpha_num'],
                'confirm_password.required' => $error['ApiErrorCodes']['users_confirm_password_required'],
                'confirm_password.same' => $error['ApiErrorCodes']['users_confirm_password_same']
            );
            $validatorError = User::validate($input, 'RULE_RESET_PASSWORD_USER', $message);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // Find confirm token
            $confirm = Confirmation::where('token', $input['token'])->first();

            // Not found
            if (empty($confirm)) {
                return $this->notFound($this->error['token_not_found'], $this->error['ApiErrorCodes']['token_not_found']);
            }

            // Has expired
            if ($this->isExpired($confirm->expired_at)) {
                return $this->badRequest($error['tokens_expired'], $error['ApiErrorCodes']['tokens_expired']);
            }

            // find user
            $user = User::find($confirm->user_id);

            // Not found user
            if (empty($user)) {
                return $this->notFound($this->error['users_not_found'], $this->error['ApiErrorCodes']['users_not_found']);
            }

            // detect account
            if (!$user->isAdmin()) {
                return $this->badRequest($error['users_access_denied'], $error['ApiErrorCodes']['users_access_denied']);
            }

            // Fill & save
            $user->fill(array(
                'password' => Hash::make($input['password'])
            ));
            $user->save();

            // delete token
            $confirm->delete();

            return $this->accepted();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/admin/logout",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Logout Admin",
     *      nickname="logout",
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->header('Authorization');

            $authToken = AuthToken::where('token', $token)->first();
            if ($authToken) {
                // remove device token
                $authToken->delete();
            }

            return $this->accepted();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}