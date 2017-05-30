<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Challenge;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Lang;
use Intervention\Image\ImageManagerStatic as Img;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/User",
 *   description="Operation of User",
 *   produces="['application/json']"
 * )
 */
class UserController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/users",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get users",
     *      nickname="getUsers",
     *
     *      @SWG\Parameter(name="keyword", description="Keyword", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="field", description="Field order by", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="order", description="Order by: ASC/DESC", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="page", description="Current Page", required=false, type="integer", paramType="query", allowMultiple=false),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated")
     *   )
     * )
     */
    public function index(Request $request)
    {
        try {
            // TODO get all users

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // get users
            $query = User::with(array(
                'location',
                'role'
            ))
                ->where('is_deleted', false)
                ->where('role_id', config('constants.ROLEs.USER'));

            // filter keyword
            if ($request->has('keyword')) {

                $keyword = $request->get('keyword');

                $query->where(function ($query) use ($keyword) {
                    $query->where('username', 'like', "%$keyword%")
                        ->orWhere('surname', 'like', "%$keyword%")
                        ->orWhere('first_name', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
                })
                    ->orWhere(function ($query) use ($keyword) {
                        $query->whereHas('location', function ($query) use ($keyword) {
                            $query->where('location', $keyword);
                        });
                    });
            }

            // order by
            if ($request->has('field')) {
                switch ($request->get('field')) {
                    case 'location': {
                        $query->leftJoin('locations', function ($query) {
                            $query->on('users.location_id', '=', 'locations.id');
                        });

                        $query->orderBy('locations.location', $request->get('order', 'ASC'));
                        break;
                    }
                    default: {
                        $query->orderBy($request->get('field'), $request->get('order', 'ASC'));
                        break;
                    }
                }
            }

            if ($request->get('page') === 'all') {
                $users = $query->get();
            } else {

                // Pagination
                $users = $query->paginate((int)$request->get('pageSize', null));
            }

            return $this->success($users);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/users/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get user",
     *      nickname="getUser",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function get(Request $request, $id = 0)
    {
        try {
            // TODO get user detail

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $credentialUser = $authToken->user;

            // get user
            $user = User::with(array(
                'location'
            ))
                ->find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            return $this->success($user);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getOverview(Request $request, $id = 0)
    {
        try {
            // TODO get challenges overview

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            if ($user->id !== (int)$id) {
                // find user
                $user = User::find($id);
                if (!$user) {
                    return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
                }
            }

            // query
            $query = Challenge::with(array(
                'game',
                'result' => function ($query) {

                }
            ))
                ->whereIn('status', array(
                    config('constants.CHALLENGE_STATUS.COMPLETED'),
                    config('constants.CHALLENGE_STATUS.DISPUTED'),
                ))
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('opponent_id', $user->id);
                });

            $challenges = $query->paginate($request->get('per_page', 20));

            foreach ($challenges as $index => $challenge) {

                if ((int)$challenge->user_id !== $user->id) {
                    $challenge->opponent = User::find($challenge->user_id);
                } else if ((int)$challenge->opponent_id !== $user->id) {
                    $challenge->opponent = User::find($challenge->opponent_id);
                }
            }

            return $this->success($challenges);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getOpponents(Request $request, $id = 0)
    {
        try {
            // TODO get opponents in challenges

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            if ($user->id !== (int)$id) {
                // find user
                $user = User::find($id);
                if (!$user) {
                    return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
                }
            }

            // query
            $query = User::with(array(
                'location'
            ))
                ->select(DB::raw('users.*'))
                ->leftJoin('challenges', function ($query) use ($user) {
                    $query->on('challenges.opponent_id', '=', 'users.id')
                        ->orWhere('challenges.user_id', '=', 'users.id');
                })
                ->where('challenges.status', config('constants.CHALLENGE_STATUS.COMPLETED'))
                ->where(function ($query) use ($user) {
                    $query->where('challenges.user_id', $user->id)
                        ->orWhere('challenges.opponent_id', $user->id);
                });

            $opponents = $query->paginate($request->get('per_page'));

            return $this->success($opponents);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getFeedback(Request $request, $id = 0)
    {
        try {
            // TODO get feedback from challenges
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="updateUser",
     * 	@SWG\Property(name="name", type="integer", required=true, defaultValue=""),
     * 	@SWG\Property(name="phone", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="address", type="string", required=true, defaultValue=""),
     * 	@SWG\Property(name="role_id", type="string", required=true, defaultValue=""),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/users/{id}",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update User",
     *      nickname="updateUser",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="updateUser", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function update(Request $request, $id = -1)
    {
        try {
            // TODO update user

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // get user
            $user = User::where('role_id', config('constants.ROLES.USER'))->find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // validation
            $messages = array(
                'name.required' => $error['ApiErrorCodes']['users_name_required'],
                'phone.required' => $error['ApiErrorCodes']['users_phone_required'],
                'phone.numeric' => $error['ApiErrorCodes']['users_phone_numeric'],
                'phone.min_number' => $error['ApiErrorCodes']['users_phone_min'],
                'phone.max_number' => $error['ApiErrorCodes']['users_phone_max'],
                'address.required' => $error['ApiErrorCodes']['users_address_required'],
                'role_id.required' => $error['ApiErrorCodes']['users_role_required']
            );
            $validatorError = User::validate($input, 'RULE_UPDATE_USER', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // check role update
            if ($request->get('role_id') == config('constants.ROLES.SUPER_ADMIN')) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
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
     *  id="resetPassword",
     * 	@SWG\Property(name="password", type="string", required=true, defaultValue="12345678"),
     * 	@SWG\Property(name="confirm_password", type="string", required=true, defaultValue="12345678")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/users/{id}/reset-password",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Reset Password of User",
     *      nickname="resetPassword",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="resetPassword", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *      @SWG\ResponseMessage(code=404, message="User is not found")
     *   )
     * )
     */
    public function resetPassword(Request $request, $id)
    {
        try {
            // TODO reset password

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // validation
            $messages = array(
                'password.required' => $error['ApiErrorCodes']['users_password_required'],
                'password.min' => $error['ApiErrorCodes']['users_password_min'],
                'password.max' => $error['ApiErrorCodes']['users_password_max'],
                'confirm_password.required' => $error['ApiErrorCodes']['users_confirm_password_required'],
                'confirm_password.same' => $error['ApiErrorCodes']['users_confirm_password_same']
            );
            $validatorError = User::validate($input, 'RULE_RESET_PASSWORD', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // get user
            $user = User::where('role_id', config('constants.ROLES.USER'))->find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // reset password
            $user->password = Hash::make($request->get('password'));
            $user->save();

            // send email
            $this->sendEmailMessage('emails.users.reset-password', array(
                'name' => $user->name,
                'password' => $input['password']
            ), config('constants.EMAILS.SUBJECTS.RESET_PASSWORD'), array(
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
     *  id="sendEmail",
     * 	@SWG\Property(name="content", type="string", required=true, defaultValue="")
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/users/{id}/send-email",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Send Email",
     *      nickname="sendEmail",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="sendEmail", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *      @SWG\ResponseMessage(code=404, message="User is not found")
     *   )
     * )
     */
    public function sendEmail(Request $request, $id)
    {
        try {
            // TODO send email to user

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // get user
            $user = User::where('role_id', config('constants.ROLES.USER'))->find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // send email
            $this->sendEmailMessage('emails.users.send-email', array(
                'name' => $user->name,
                'content' => $input['content']
            ), config('constants.EMAILS.SUBJECTS.SEND_EMAIL'), array(
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
     * @SWG\Api(
     *   path="/api/users/{id}/upload",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Upload Avatar",
     *      nickname="uploadAvatar",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="avatar", description="File Image", required=true, type="file", paramType="query", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *      @SWG\ResponseMessage(code=404, message="User is not found")
     *   )
     * )
     */
    public function uploadAvatar(Request $request, $id)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // get user
            $user = User::find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                // TODO upload
                $destinationPath = base_path(config('constants.PATH.USER') . '/' . $user->id);
                $filename = $user->id . '.' . $file->getClientOriginalExtension();

                // make directory path
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                // move file
                $file->move($destinationPath, $filename);

                // remove image
                if ($user->path && File::exists($user->path)) {
                    File::delete($user->path);
                }

                // save path image of user
                $user->fill(array(
                    'path' => config('constants.PATH.USER') . '/' . $user->id . '/' . $filename
                ));
                $user->save();

                return $this->success(array(
                    'src' => url("/api/images/users/$user->id" . '?ver=' . rand(0, 1000000)),
                    'thumbnail' => url("/api/images/users/$user->id/thumbnail" . '?ver=' . rand(0, 1000000)),
                    'type_image' => User::checkSizeImage($user->path),
                    'path' => $user->path
                ));
            }

            return $this->badRequest();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/users/{id}",
     *   @SWG\Operation(
     *      method="DELETE",
     *      summary="Delete User",
     *      nickname="deleteUser",
     *
     *      @SWG\Parameter( name="id", description="User Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated")
     *   )
     * )
     */
    public function delete(Request $request, $id)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // get user
            $user = User::where('role_id', config('constants.ROLES.USER'))->find($id);
            if (empty($user)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // delete all image of user
            $destinationPath = base_path(config('constants.PATH.USER') . '/' . $user->id);
            if (File::exists($destinationPath)) {
                File::deleteDirectory($destinationPath);
            }

            // delete user
            $user->fill(array(
                'is_deleted' => true
            ));
            $user->save();

            return $this->accepted();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}