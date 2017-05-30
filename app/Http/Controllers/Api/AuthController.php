<?php

namespace App\Http\Controllers\Api;

use App\Events\Event;
use App\Http\Controllers\ApiBasicController;
use App\Jobs\SendForgotEmail;
use App\Jobs\SendVerifyEmail;
use App\Models\AuthToken;
use App\Models\Confirmation;
use App\Models\User;
use App\Models\VerifyCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use League\Flysystem\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Nexmo\Laravel\Facade\Nexmo;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Authentication",
 *   description="Operation of Authentication",
 *   produces="['application/json']"
 * )
 */
class AuthController extends ApiBasicController
{
    // constructor
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Model(
     *  id="registerUser",
     * 	@SWG\Property(name="username", type="string", required=true, defaultValue="name"),
     * 	@SWG\Property(name="email", type="string", required=true, defaultValue="test@gmail.com"),
     * 	@SWG\Property(name="confirm_email", type="string", required=true, defaultValue="test@gmail.com"),
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue="12345678"),
     * 	@SWG\Property(name="confirm_password", type="string", required=true, defaultValue="12345678"),
     * 	@SWG\Property(name="phone", type="integer", required=true, defaultValue="123456"),
     * 	@SWG\Property(name="is_term_condition", type="boolean", required=true, defaultValue=true),
     * 	@SWG\Property(name="is_privacy_policy", type="boolean", required=true, defaultValue=true),
     * 	@SWG\Property(name="is_subscribe_email", type="boolean", required=false, defaultValue=true),
     * 	@SWG\Property(name="location_id", type="integer", required=false, defaultValue="1"),
     *  @SWG\Property(name="date_of_birth", type="string", required=false, defaultValue="1/1/2000")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/register",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Register As User",
     *      nickname="registerUser",
     *
     *      @SWG\Parameter(name="body", description="Request body", required=true, type="registerUser", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function register(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            // validation
            $messages = array(
                'username.required' => $error['ApiErrorCodes']['users_username_required'],
                'username.unique' => $error['ApiErrorCodes']['users_username_unique'],
                'username.min' => $error['ApiErrorCodes']['users_username_min'],
                'username.max' => $error['ApiErrorCodes']['users_username_max'],
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'email.unique' => $error['ApiErrorCodes']['users_email_unique'],
                'confirm_email.required' => $error['ApiErrorCodes']['users_confirm_email_required'],
                'confirm_email.same' => $error['ApiErrorCodes']['users_confirm_email_same'],
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.regex' => $error['ApiErrorCodes']['users_password_regex'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'confirm_password.required' => $error['ApiErrorCodes']['users_confirm_password_required'],
                'confirm_password.same' => $error['ApiErrorCodes']['users_confirm_password_same'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'phone.min' => $error['ApiErrorCodes']['users_phone_min'],
                'phone.max' => $error['ApiErrorCodes']['users_phone_max'],
                'phone.regex' => $error['ApiErrorCodes']['users_phone_invalid'],
                'location_id.required' => $error['ApiErrorCodes']['users_location_required'],
                'date_of_birth.required' => $error['ApiErrorCodes']['users_date_of_birth_required'],
                'is_term_condition.required' => $error['ApiErrorCodes']['users_is_term_required'],
                'is_privacy_policy.required' => $error['ApiErrorCodes']['users_is_privacy_required'],
                'is_term_condition.boolean' => $error['ApiErrorCodes']['users_term_boolean'],
                'is_privacy_policy.boolean' => $error['ApiErrorCodes']['users_privacy_boolean']
            );
            $validatorError = User::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // set inputs
            $input['password'] = Hash::make($input['password']);
            $input['role_id'] = config('constants.ROLEs.USER');
            $input['status'] = config('constants.USER_STATUS.NEW');

            //check is_term, is_privacy
            if (!$request->get('is_term_condition')) {
                return $this->badRequest($error['users_is_term_required'], $error['ApiErrorCodes']['users_is_term_required']);
            }
            if (!$request->get('is_privacy_policy')) {
                return $this->badRequest($error['users_is_privacy_required'], $error['ApiErrorCodes']['users_is_privacy_required']);
            }

            // store new user
            $user = new User($input);
            $user->fill(array(
                'status' => config('constants.USER_STATUS.VERIFY_OTP')
            ));

            // generate verify OTP
            $response = $this->sendVerifyOTP($user->phone, 'Play Or Go');

            //if verify OTP get error
            if ((!$response) OR is_numeric($response)) {
                if ($response === 3) {
                    return $this->badRequest($error['users_phone_invalid'], $error['ApiErrorCodes']['users_phone_invalid']);
                }
            }

            //set verify required id to user
            $user->fill(array(
                'verify_required_id' => $response
            ));

            $user->save();

            // first login after registration
            Session::put('timezone', $request->get('timezone', 0));
            $authToken = AuthToken::login($request->get('email'), $request->get('password'), $request->get('is_remember', false), $request->get('timezone', 0));

            // check login
            if ($authToken) {
                // get info
                return $this->success($authToken);
            }

        } catch (Extention $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="loginUser",
     * 	@SWG\Property(name="email", type="string", required=true, defaultValue="test@gmail.com"),
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue="123456"),
     * 	@SWG\Property(name="is_remember", type="boolean", required=true, defaultValue=false),
     * 	@SWG\Property(name="timezone", type="integer", required=true, defaultValue="7")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/login",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Login as User Account",
     *      nickname="loginAsUser",
     *
     *      @SWG\Parameter(name="body", description="Request body", required=true, type="loginUser", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
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

            // validation
            $messages = array(
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'password.regex' => $error['ApiErrorCodes']['users_password_regex'],
            );
            $validatorError = User::validate($input, 'RULE_LOGIN', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // store timezone in session
            Session::put('timezone', $request->get('timezone', 0));

            $user = User::where('email', $input['email'])->first();
            // check email is exit
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // check user is delete
            if (!!$user->isDeleted()) {
                return $this->notFound($error['users_deleted'], $error['ApiErrorCodes']['users_deleted']);
            }

            $authToken = AuthToken::login($input['email'], $input['password'], $request->get('is_remember', false), $request->get('timezone', 0));

            // check login
            if ($authToken) {
                // get info
                $authToken->user->location;
                return $this->success($authToken);
            }

            return $this->badRequest($error['users_password_incorrect'], $error['ApiErrorCodes']['users_password_incorrect']);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="loginSocial",
     * 	@SWG\Property(name="email", type="string", required=false, defaultValue="123456@facebook.com"),
     * 	@SWG\Property(name="social_id", type="integer", required=true, defaultValue="123456"),
     * 	@SWG\Property(name="social_type", type="string", required=true, defaultValue="facebook"),
     * 	@SWG\Property(name="is_remember", type="boolean", required=true, defaultValue=false),
     * 	@SWG\Property(name="timezone", type="integer", required=true, defaultValue="7")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/login-social",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Login as User Account",
     *      nickname="loginAsUser",
     *
     *      @SWG\Parameter(name="body", description="Request body", required=true, type="loginSocial", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function loginSocial(Request $request)
    {
        try {
            $error = $this->error;
            $input = $request->input();

            // validation
            $messages = array(
                'username.required' => $error['ApiErrorCodes']['users_username_required'],
                'username.unique' => $error['ApiErrorCodes']['users_username_unique'],
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'email.unique' => $error['ApiErrorCodes']['users_email_unique'],
                'social_id.required' => $error['ApiErrorCodes']['users_social_id_required'],
                'social_type.required' => $error['ApiErrorCodes']['users_social_type_required'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'phone.regex' => $error['ApiErrorCodes']['users_phone_invalid']
            );

            $merge = array();

            //check if email exist
            if ($request->has('email')) {
                $merge['email'] = 'required|email';
                $otherEmail = User::where('email', $request->get('email', null))
                    ->where('social_id', '<>', $input['social_id'])
                    ->first();
                if ($otherEmail) {
                    return $this->badRequest($error['users_email_unique'], $error['ApiErrorCodes']['users_email_unique']);
                }
            }

            $validatorError = User::validate($input, 'RULE_LOGIN_SOCIAL', $messages, $merge);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // get user
            $user = User::where('social_id', $input['social_id'])
                ->where('social_type', $input['social_type'])
                ->orWhere('email', $request->get('email', null))
                ->first();

            // check user is exist
            if (empty($user)) {
                // TODO register new account
                $social_id = $input['social_id'];

                // register
                $user = new User(array(
                    'email' => $request->get('email', NULL),
                    'social_id' => $input['social_id'],
                    'social_type' => $input['social_type'],
                    'role_id' => config('constants.ROLEs.USER'),
                    'is_term_condition' => true,
                    'is_privacy_policy' => true,
                    'is_subscribe_email' => true,
                    'path' => "https://graph.facebook.com/$social_id/picture?type=large",
                    'status' => config('constants.USER_STATUS.UPDATE')
                ));
                $user->save();

                // generate verify OTP
                // TODO
            }
            // store timezone in session
            Session::put('timezone', $request->get('timezone', 0));

            // login
            $authToken = AuthToken::loginBySocialNetwork($request->get('email', NULL), $input['social_id'], $input['social_type'], $request->get('is_remember', false), $request->get('timezone', 0));

            // check login
            if ($authToken) {
                // get info
                $authToken->user->role;
                $authToken->user->location;

                return $this->success($authToken);
            }
            return $this->badRequest($error['users_password_incorrect'], $error['ApiErrorCodes']['users_password_incorrect']);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/auth/me",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Find Me As User",
     *      nickname="findMe",
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
            // TODO find current user by token

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect user not found
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // get role of user
            $user->role;
            $user->location;

            return $this->success($user);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="updateMeUser",
     * 	@SWG\Property(name="username", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="phone", type="string", required=true, defaultValue=""),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/me",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update Me",
     *      nickname="updateMe",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="updateMeUser", paramType="body", allowMultiple=false),
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
            // TODO update information as company

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            $input = $request->input();

            // validate
            $messages = array(
                'username.required' => $error['ApiErrorCodes']['users_username_required'],
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'phone.regex' => $error['ApiErrorCodes']['users_phone_invalid'],
                'phone.min' => $error['ApiErrorCodes']['users_phone_min'],
                'phone.max' => $error['ApiErrorCodes']['users_phone_max']
            );
            $validatorError = User::validate($input, 'RULE_UPDATE_ME', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // unset password
            unset($input['password']);

            // detect username
            $otherUsername = User::where('username', $input['username'])
                ->where('id', '<>', $user->id)
                ->first();
            if ($otherUsername) {
                return $this->badRequest($error['users_username_unique'], $error['ApiErrorCodes']['users_username_unique']);
            }

            // detect email
            if ($user->email !== $request->get('email')) {
                $otherUser = User::where('email', $request->get('email'))
                    ->where('id', '<>', $user->id)
                    ->first();

                if ($otherUser) {
                    return $this->badRequest($error['users_email_unique'], $error['ApiErrorCodes']['users_email_unique']);
                }
            }

            // update user
            $user->fill($input);
            $user->save();

            return $this->success($user);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="updateAdditionalInfoUser",
     * 	@SWG\Property(name="username", type="string", required=true, defaultValue="username"),
     * 	@SWG\Property(name="email", type="string", required=false, defaultValue="test@mail.com"),
     * 	@SWG\Property(name="phone", type="string", required=true, defaultValue="123456789"),
     * 	@SWG\Property(name="location_id", type="integer", required=true, defaultValue=1),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/additional-info",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update Additional Info User",
     *      nickname="updateAdditionInfo",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="updateAdditionalInfoUser", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function updateAdditionalInfo(Request $request)
    {
        try {
            // TODO update addition for facebook account

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // detect social account
            if (!$user->isSocialAccount()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // validation
            $messages = array(
                'username.required' => $error['ApiErrorCodes']['users_username_required'],
                'username.unique' => $error['ApiErrorCodes']['users_username_unique'],
                'username.min' => $error['ApiErrorCodes']['users_username_min'],
                'username.max' => $error['ApiErrorCodes']['users_username_max'],
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email'],
                'email.unique' => $error['ApiErrorCodes']['users_email_unique'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'phone.min' => $error['ApiErrorCodes']['users_phone_min'],
                'phone.max' => $error['ApiErrorCodes']['users_phone_max'],
                'phone.regex' => $error['ApiErrorCodes']['users_phone_invalid'],
                'location_id.required' => $error['ApiErrorCodes']['users_location_required']
            );

            $merge = array();
            if ($request->has('email')) {
                $merge['email'] = 'required|email';
                $otherEmail = User::where('email', $request->get('email'))
                    ->where('id', '<>', $user->id)
                    ->first();
                if ($otherEmail) {
                    return $this->badRequest($error['users_email_unique'], $error['ApiErrorCodes']['users_email_unique']);
                }
            }

            //validation
            $validatorError = User::validate($input, 'RULE_UPDATE_ADDITIONAL_INFO', $messages, $merge);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            //check username
            $otherUsername = User::where('username', $input['username'])
                ->where('id', '<>', $user->id)
                ->first();

            if ($otherUsername) {
                return $this->badRequest($error['users_username_unique'], $error['ApiErrorCodes']['users_username_unique']);
            }

            // update user
            $input['status'] = config('constants.USER_STATUS.VERIFY_OTP');
            $user->fill($input);
            $user->save();

            // get relationship items
            $user->role;
            $user->location;

            return $this->success($user);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="changePassword",
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="new_password", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="confirm_password", type="string", required=true, defaultValue="")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/change-password",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Change password of user",
     *      nickname="changePassword",
     *
     *     	@SWG\Parameter(name="body", description="Request body", required=true, type="changePassword", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function changePassword(Request $request)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            $input = $request->input();

            // validation
            $messages = array(
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'new_password.required' => $error['ApiErrorCodes']['users_new_password_required'],
                'new_password.regex' => $error['ApiErrorCodes']['users_new_password_regex'],
                'new_password.min' => $error['ApiErrorCodes']['users_new_password_min'],
                'new_password.max' => $error['ApiErrorCodes']['users_new_password_max'],
                'confirm_password.required' => $error['ApiErrorCodes']['users_confirm_password_required'],
                'confirm_password.same' => $error['ApiErrorCodes']['users_confirm_password_same'],
            );
            $validatorError = User::validate($input, 'RULE_CHANGE_PASSWORD_USER', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // check password
            if (Hash::check($input['password'], $user->password)) {
                $user->password = Hash::make($input['new_password']);

                $user->save();

                return $this->success($user);
            }

            return $this->badRequest($error['password_incorrect'], $error['ApiErrorCodes']['password_incorrect']);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/auth/upload",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Upload Avatar of user",
     *      nickname="uploadAvatar",
     *
     *     	@SWG\Parameter(name="avatar", description="Request body", required=true, type="file", paramType="path", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // check input file
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                // TODO upload
                $destinationPath = base_path(config('constants.PATH.USER') . '/' . $user->id);
                $filename = date('m-d-Y-H-i-s') . '-' . $user->id . '.' . $file->getClientOriginalExtension();

                // make directory path
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                // move file
                $file->move($destinationPath, $filename);

                // delete file image old
                if (File::exists($destinationPath . '/' . $user->path)) {
                    File::delete($destinationPath . '/' . $user->path);
                }

                // remove image
                if ($user->path && File::exists($user->path)) {
                    File::delete($user->path);
                }

                // save path image of user
                $user->path = config('constants.PATH.USER') . '/' . $user->id . '/' . $filename;
                $user->save();

                return $this->success($user);
            }

            return $this->notFound($error['users_avatar_required'], $error['ApiErrorCodes']['users_avatar_required']);
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="forgotPassword",
     * 	@SWG\Property(name="email", type="string", required=true, defaultValue="toan.le@beesightsoft.com")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/forgot",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Forgot password of user",
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
            // TODO request forgot password from user

            $error = $this->error;
            $input = $request->input();

            // validation
            $messages = array(
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email']
            );
            $validatorError = User::validate($input, 'RULE_FORGOT_PASSWORD', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // detect email of user
            $user = User::where('email', $input['email'])->first();

            // Not found
            if (empty($user)) {
                return $this->badRequest($error['users_email_invalid'], $error['ApiErrorCodes']['users_email_invalid']);
            }

            // user was deleted
            if ($user->isDeleted()) {

                return $this->badRequest($error['user_deleted'], $error['ApiErrorCodes']['users_deleted']);
            }

            // detect account type
            if ($user->social_id || $user->social_type) {
                return $this->badRequest(str_replace(':social', ucfirst($user->social_type), $error['users_social']), $error['ApiErrorCodes']['users_social']);
            }

            // token
            $token = $this->generateToken();
            $confirm = new Confirmation();
            $confirm->fill(array(
                'token' => $token,
                'user_id' => $user->id,
                'expired_at' => Carbon::now()->addHour(config('constants.LIVE_HOURS_TOKEN'))
            ));
            $confirm->save();

            // send forgot email to user by queue
            $sendForgotEmailJob = new SendForgotEmail($user, $confirm);
            $this->dispatch($sendForgotEmailJob);

            return $this->success();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     *
     * @SWG\Api(
     *   path="/api/auth/confirm-token",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Check Token is expired",
     *      nickname="forgotPassword",
     *
     *     	@SWG\Parameter(name="token", description="Verify code", required=true, type="string", paramType="query", allowMultiple=false),
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
            if ($confirm->isExpired()) {
                return $this->badRequest($error['tokens_expired'], $error['ApiErrorCodes']['tokens_expired']);
            }

            if ($confirm->user) {
                if ($confirm->user->isRegisteredAccount() AND $confirm->user->isVerifyEmail()) {
                    // TODO detect verify email to account

                    //Check token is the newest
                    $otherToken = Confirmation::where('user_id', $confirm->user_id)
                        ->where('token' , '<>' , $confirm->token)
                        ->where('expired_at', '>' , $confirm->expired_at)
                        ->first();
                    if ($otherToken) {
                        return $this->badRequest($error['tokens_expired'], $error['ApiErrorCodes']['tokens_expired']);
                    }

                    $confirm->user->fill(array(
                        'status' => config('constants.USER_STATUS.DONE')
                    ));
                    $confirm->user->save();
                } else {
                    // TODO detect token to reset password

                    // do not anything
                }
            }
            return $this->success($confirm->user);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="resetPasswordUser",
     * 	@SWG\Property(name="token", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue="123456"),
     * 	@SWG\Property(name="confirm_password", type="string", required=true, defaultValue="123456789")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/reset",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Reset Password of User",
     *      nickname="resetPassword",
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
            // TODO reset password
            $error = $this->error;
            $input = $request->input();

            // validate
            $message = array(
                'token.required' => $error['ApiErrorCodes']['tokens_token_required'],
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'password.regex' => $error['ApiErrorCodes']['users_password_regex'],
                'confirm_password.required' => $error['ApiErrorCodes']['users_confirm_password_required'],
                'confirm_password.same' => $error['ApiErrorCodes']['users_confirm_password_same']
            );
            $validatorError = User::validate($input, 'RULE_RESET_PASSWORD', $message);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // Find confirm token
            $confirm = Confirmation::where('token', $input['token'])->first();

            // Not found
            if (empty($confirm)) {
                return $this->notFound($error['tokens_not_found'], $error['ApiErrorCodes']['tokens_not_found']);
            }

            // Has expired
            if ($confirm->isExpired()) {
                return $this->badRequest($error['tokens_expired'], $error['ApiErrorCodes']['tokens_expired']);
            }

            // find user
            $user = User::find($confirm->user_id);

            // Not found user
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // detect user deleted
            if ($user->isDeleted()) {
                return $this->notFound($error['users_deleted'], $error['ApiErrorCodes']['users_deleted']);
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
     * @SWG\Model(
     *  id="resendVerifyEmail",
     *  @SWG\Property(name="email", type="string", required=true, defaultValue=""),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/auth/resend-verify",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Resend Verify Email of User",
     *      nickname="resendVerifyEmail",
     *
     *     	@SWG\Parameter(name="body", description="Request Body", required=true, type="resendVerifyEmail", paramType="body", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Invalid request params"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function resendVerifyEmail(Request $request)
    {
        try {
            // TODO request resend verify email for user

            $error = $this->error;
            $input = $request->input();

            $messages = array(
                'email.required' => $error['ApiErrorCodes']['users_email_required'],
                'email.email' => $error['ApiErrorCodes']['users_email_email']
            );

            //validation
            $validatorError = User::validate($input, 'RULE_RESEND_VERIFY_EMAIL', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // detect email of user
            $user = User::where('email', $input['email'])->first();

            // Not found
            if (empty($user)) {
                return $this->badRequest($error['users_email_invalid'], $error['ApiErrorCodes']['users_email_invalid']);
            }

            // user was deleted
            if ($user->isDeleted()) {

                return $this->badRequest($error['user_deleted'], $error['ApiErrorCodes']['users_deleted']);
            }

            // detect account type
            if ($user->social_id || $user->social_type) {
                return $this->badRequest(str_replace(':social', ucfirst($user->social_type), $error['users_social']), $error['ApiErrorCodes']['users_social']);
            }

            // token
            $token = $this->generateToken();
            $confirm = new Confirmation();
            $confirm->fill(array(
                'token' => $token,
                'user_id' => $user->id,
                'expired_at' => Carbon::now()->addHour(config('constants.LIVE_HOURS_VERIFY_TOKEN'))
            ));
            $confirm->save();

            // send verify email to user by queue
            $sendVerifyEmailJob = new SendVerifyEmail($user, $confirm);
            $this->dispatch($sendVerifyEmailJob);

            // send message
            /*$this->sendEmailMessage('emails.auth.forgot',
                array(
                    'user' => $user,
                    'link' => config('constants.LINKs.FORGOT') . "/$confirm->token"
                ),
                config('constants.EMAILs.SUBJECT.FORGOT'),
                array(
                    'email' => config('constants.EMAILs.SUPPORT'),
                    'name' => config('constants.NAME')
                ),
                array(
                    'email' => $user->email,
                    'name' => $user->username,
                ));*/
            return $this->success();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/auth/logout",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Logout",
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