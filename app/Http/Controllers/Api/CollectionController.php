<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Role;
use App\Models\Dispute;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Img;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Dispute",
 *   description="Operation of Dispute",
 *   produces="['application/json']"
 * )
 */
class CollectionController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/disputes",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get disputes",
     *      nickname="getDisputes",
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
            // TODO get all disputes

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            $disputes = Dispute::orderBy('created_at', 'ASC')->all();

            return $this->success($disputes);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }


    /**
     * @SWG\Api(
     *   path="/api/disputes/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Dispute",
     *      nickname="getDispute",
     *
     *      @SWG\Parameter( name="id", description="Dispute Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function get(Request $request, $id)
    {
    }

    /**
     * @SWG\Model(
     *  id="createDispute",
     * 	@SWG\Property(name="challenge_id", type="integer", required=true, defaultValue=""),
     * )
     */
    /**
     * @SWG\Api(
     *   path="/api/disputes/",
     *   @SWG\Operation(
     *      method="POST",
     *      summary="Create Dispute",
     *      nickname="createDispute",
     *
     *      @SWG\Parameter( name="body", description="Request body", required=true, type="createDispute", paramType="body", allowMultiple=false ),
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
            // TODO create new dispute

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            $input = $request->input();

            // validation
            $messages = array(
                'challenge_id.required' => $error['ApiErrorCodes']['disputes_challenge_id_required'],
                'challenge_id.numeric' => $error['ApiErrorCodes']['disputes_challenge_id_number'],
                'date.required' => $error['ApiErrorCodes']['disputes_date_required'],
                'date.date' => $error['ApiErrorCodes']['disputes_date_date']
            );
            $validatorError = Dispute::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // create new dispute
            $dispute = new Dispute($input);
            $dispute->fill(array(
                'challenge_id' => $input['challenge_id'],
                'date' => Carbon::now(),
                'status' => config('constants.DISPUTE_STATUS.NEW')
            ));
            $dispute->save();

            return $this->success($dispute);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/disputes/{id}/solve",
     *   @SWG\Operation(
     *      method="PUT",
     *      summary="Update Dispute Status to Solve",
     *      nickname="updateDisputeSolve",
     *
     *      @SWG\Parameter( name="id", description="Dispute Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function solve(Request $request, $id = 0)
    {
        try {
            // TODO update dispute status to solve

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // find dispute
            $dispute = Dispute::find($id);
            if (!$dispute) {
                return $this->notFound($error['disputes_not_found'], $error['ApiErrorCodes']['disputes_not_found']);
            }

            $dispute->fill(array(
                'status' => config('constants.DISPUTE_STATUS.SOLVED')
            ));
            $dispute->save();

            return $this->accepted($dispute);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/disputes/{id}",
     *   @SWG\Operation(
     *      method="DELETE",
     *      summary="Delete Dispute",
     *      nickname="deleteDispute",
     *
     *      @SWG\Parameter( name="id", description="Dispute Id", required=true, type="integer", paramType="path", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=202, message="Accept"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated")
     *   )
     * )
     */
    public function destroy(Request $request, $id = 0)
    {
        try {
            // TODO delete dispute

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // find dispute
            $dispute = Dispute::find($id);
            if (!$dispute) {
                return $this->notFound($error['disputes_not_found'], $error['ApiErrorCodes']['disputes_not_found']);
            }

            $dispute->delete();

            return $this->accepted($dispute);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
