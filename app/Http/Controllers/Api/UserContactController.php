<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\UserContact;
use App\Models\Product;
use App\Models\Result;
use App\Models\Role;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Img;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Game",
 *   description="Operation of Game",
 *   produces="['application/json']"
 * )
 */
class UserContactController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/categories/",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Categories",
     *      nickname="getCategories",
     *
     *      @SWG\Parameter(name="per_page", description="per_page", required=false, type="integer", paramType="query", allowMultiple=false),
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
            // TODO get all categories
            $query = new UserContact();
            $usercontact = $query->paginate($request->get('per_page', 10));
            return $this->success($usercontact);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }


    /**
     * @SWG\Api(
     *   path="/api/caterogies/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get single Categories",
     *      nickname="getCategories",
     *
     *      @SWG\Parameter( name="id", description="Categories Id", required=true, type="integer", paramType="path", allowMultiple=false ),
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
            // TODO find game by id

            $error = $this->error;
//            $authToken = $request->attributes->get('authToken');
//            $user = $authToken->user;

            // find game
            $usercontact = UserContact::find($id);
            if (!$usercontact) {
                return $this->notFound($error['usercontacts_not_found'], $error['ApiErrorCodes']['usercontacts_not_found']);
            }

            return $this->success($usercontact);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }


    public function update(Request $request, $id = 0)
    {
        try {
            // TODO update game

            // detect user permission

            // find game

            // validate

            // update game

            return $this->success();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function destroy(Request $request, $id = 0)
    {
        try {
            // TODO destroy game

            // detect user permission

            // find game

            // delete game

            return $this->accepted();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
