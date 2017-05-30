<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Challenge;
use App\Models\User;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Lang;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Product",
 *   description="Operation of Product",
 *   produces="['application/json']"
 * )
 */
class ProductController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/products",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get products",
     *      nickname="getProducts",
     *
     *      @SWG\Parameter(name="type", description="type [pending|activated]", required=false, type="string", paramType="query", allowMultiple=false),
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
            // TODO get challenges by

            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // query
            $query = Challenge::with(array(
                'user',
                'opponent'
            ))
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('opponent_id', $user->id);
                });

            // detect by type
            switch ($request->get('type')) {
                case 'pending': {
                    $query->whereIn('status', array(
                        config('constants.CHALLENGE_STATUS.NEW'),
                        config('constants.CHALLENGE_STATUS.WAITING')
                    ))
                        ->orderBy('created_at', 'DESC');

                    break;
                }
                case 'activated': {
                    $query->where('status', config('constants.CHALLENGE_STATUS.ACTIVATED'))
                        ->orderBy('start_at');
                    break;
                }
            }
            $challenges = $query->paginate($request->get('per_page', 10));
            return $this->success($challenges);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/challenges/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get challenge",
     *      nickname="getChallenge",
     *
     *      @SWG\Parameter( name="id", description="Challenge Id", required=true, type="integer", paramType="path", allowMultiple=false ),
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
    }

    /**
     * @SWG\Model(
     *  id="createChallenge",
     * 	@SWG\Property(name="game_id", type="integer", required=true, defaultValue="1"),
     * 	@SWG\Property(name="opponent_id", type="integer", required=true, defaultValue="1"),
     * 	@SWG\Property(name="amount", type="integer", required=true, defaultValue="1"),
     * 	@SWG\Property(name="confirm_amount", type="integer", required=true, defaultValue="1"),
     * 	@SWG\Property(name="description", type="string", required=true, defaultValue="demo"),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/challenges/",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Create Challenge",
     *      nickname="createChallenge",
     *
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="createChallenge", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function create(Request $request)
    {
        try {
            // TODO create new challenge

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // validation
            $messages = array(
                'game_id.required' => $error['ApiErrorCodes']['challenges_game_id_required'],
                'opponent_id.required' => $error['ApiErrorCodes']['challenges_opponent_id_required'],
                'amount.required' => $error['ApiErrorCodes']['challenges_amount_required'],
                'amount.min' => $error['ApiErrorCodes']['challenges_amount_min'],
                'amount.max' => $error['ApiErrorCodes']['challenges_amount_max'],
                'amount.numeric' => $error['ApiErrorCodes']['challenges_amount_invalid'],
                'amount.regex' => $error['ApiErrorCodes']['challenges_amount_regex'],
                'confirm_amount.required' => $error['ApiErrorCodes']['challenges_confirm_amount_required'],
                'confirm_amount.same' => $error['ApiErrorCodes']['challenges_confirm_amount_same'],
                'description.required' => $error['ApiErrorCodes']['challenges_description_required'],
            );
            $validatorError = Challenge::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // find game
            $game = Game::find($request->get('game_id'));
            if (!$game) {
                return $this->notFound($error['games_not_found'], $error['ApiErrorCodes']['game_not_found']);
            }

            // find opponent
            $opponent = User::find($request->get('opponent_id'));
            if (!$opponent) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            // set params
            $challenge = new Challenge($input);

            $challenge->fill(array(
                'user_id' => $user->id,
                'user_status' => config('constants.CHALLENGE_STATUS.ACCEPTED'),
                'opponent_status' => config('constants.CHALLENGE_STATUS.NEW'),
                'status' => config('constants.CHALLENGE_STATUS.WAITING'),
                'length' => 45,
                'start_at' => Carbon::now()
            ));
            $challenge->save();

            // notification to opponent
            $this->sendNotifyTo('Head To Head Challenge', config('constants.NOTIFICATIONs.NEW_CHALLENGE'), array(
                '@game' => $game->name,
                '@user' => $user->surname
            ), $opponent, $challenge);

            return $this->created($challenge);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="activeChallenge",
     * 	@SWG\Property(name="action", type="string", required=true, defaultValue=""),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/challenges/{id}/{action}",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Active Challenge",
     *      nickname="activeChallenge",
     *
     *      @SWG\Parameter( name="id", description="Challenge Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="action", description="action [accept|decline]", required=true, type="activeChallenge", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function activeChallenge(Request $request, $id = 0, $action = null)
    {
        try {

            // TODO active challenge
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // find challenge
            $challenge = Challenge::find($id);

            if (!$challenge) {
                return $this->notFound($error['challenges_not_found'], $error['ApiErrorCodes']['challenges_not_found']);
            }

            switch ($request->get('action')) {
                case 'accept': {
                    // TODO accept and detect who accepted

                    if ($challenge->isDeclined()) {
                        return $this->badRequest($error['challenges_declined'], $error['ApiErrorCodes']['challenges_declined']);
                    }

                    if ($challenge->isAccepted()) {
                        return $this->badRequest($error['challenges_running'], $error['ApiErrorCodes']['challenges_running']);
                    }

                    // update challenge
                    $challenge->fill(array(
                        'opponent_status' => config('constants.CHALLENGE_STATUS.ACCEPTED'),
                        'status' => config('constants.CHALLENGE_STATUS.ACCEPTED'),
                        'start_at' => Carbon::now()
                    ));
                    $challenge->save();

                    // send notification
                    $this->sendNotifyTo('Head To Head Challenge Accepted', config('constants.NOTIFICATIONs.ACCEPT_CHALLENGE'), array(
                        '@game' => $challenge->game->name,
                        '@user' => $challenge->opponent->surname
                    ), $user, $challenge);

                    break;
                }
                case 'decline': {
                    // TODO decline to challenge

                    if ($challenge->isAccepted()) {
                        return $this->badRequest($error['challenges_running'], $error['ApiErrorCodes']['challenges_running']);
                    }

                    // update challenge
                    $challenge->fill(array(
                        'opponent_STATUS' => config('constants.CHALLENGE_STATUS.DECLINED'),
                        'status' => config('constants.CHALLENGE_STATUS.DECLINED')
                    ));
                    $challenge->save();

                    // send notification
                    $this->sendNotifyTo('Head To Head Challenge Declined', config('constants.NOTIFICATIONs.DECLINE_CHALLENGE'), array(
                        '@game' => $challenge->game->name,
                        '@user' => $challenge->opponent->surname
                    ), $user, $challenge);

                    break;
                }
            }

            return $this->accepted($challenge);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Model(
     *  id="updateChallenge",
     *  @SWG\Property(name="amount",  type="integer", required=true, defaultValue="10.52"),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/challenges/{id}",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update Challenge",
     *      nickname="updateChallenge",
     *
     *      @SWG\Parameter( name="id", description="Challenge Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="updateChallenge", paramType="body", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function update(Request $request, $id = 0)
    {
        try {
            // TODO update challenge (raise)

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // find challenge
            $challenge = Challenge::where(function ($query) use ($user) {
                if ($user->isUser()) {
                    // filter by owner or opponent

                    $query->where('user_id', $user->id)
                        ->orWhere('opponent_id', $user->id);
                }
            })->find($id);

            if (!$challenge) {
                return $this->notFound($error['challenges_not_found'], $error['ApiErrorCodes']['challenges_not_found']);
            }

            // validation
            $messages = array(
                'amount.required' => $error['ApiErrorCodes']['challenges_amount_required'],
                'amount.min' => $error['ApiErrorCodes']['challenges_amount_min'],
                'amount.max' => $error['ApiErrorCodes']['challenges_amount_max'],
                'amount.numeric' => $error['ApiErrorCodes']['challenges_amount_invalid'],
                'amount.regex' => $error['ApiErrorCodes']['challenges_amount_regex']
            );
            $validatorError = Challenge::validate($input, 'RULE_UPDATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            //save old amount
            $oldAmount = $challenge->amount;

            //check status of user
            if($challenge->user_status === config('constants.CHALLENGE_STATUS.ACCEPTED')){
                return $this->badRequest($error['challenges_users_accepted'], $error['ApiErrorCodes']['challenges_users_accepted']);
            }

            if($challenge->opponent_status === config('constants.CHALLENGE_STATUS.DECLINE')){
                return $this->badRequest($error['challenges_users_declined'], $error['ApiErrorCodes']['challenges_users_declined']);
            }

            // update challenge
            $challenge->fill(array(
                'amount' => $input['amount']
            ));
            $challenge->save();

            // send notification
            $this->sendNotifyTo(
                'Head To Head Challenge Raised',
                config('constants.NOTIFICATIONs.RAISE_CHALLENGE'),
                array(
                    '@game' => $challenge->game->name,
                    '@user' => $user->id === $challenge->user->id ? $challenge->opponent->surname : $challenge->user->surname,
                    '@old_amount' => $oldAmount,
                    '@new_amount' => $input['amount']
                ),
                $user->id === $challenge->user->id ? $challenge->opponent : $user,
                $challenge);

            return $this->accepted($challenge);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/challenges/{id}",
     *   @SWG\Operation(
     *      method="DELETE",
     *      summary="Delete Challenge",
     *      nickname="deleteChallenge",
     *
     *      @SWG\Parameter( name="id", description="Challenge Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated")
     *   )
     * )
     */
    public function destroy($id)
    {
        try {
            // TODO destroy challenge


        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
