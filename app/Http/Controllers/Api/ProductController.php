<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Product;
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
     *      @SWG\Parameter(name="type", description="type [categories|collections]", required=false, type="string", paramType="query", allowMultiple=false),
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
            // TODO get product by

            // $authToken = $request->attributes->get('authToken');
            // $user = $authToken->user;

            // query
            $query = Product::with(array(
                'categories',
                'collection'
            ));
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

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permission_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // validation
            $messages = array(
                'collection_id.required' => $error['ApiErrorCodes']['products_collection_id_required'],
                'categories_id.required' => $error['ApiErrorCodes']['products_categories_id_required'],
                'name.required' => $error['ApiErrorCodes']['products_name_required'],
                'detail.requireds' => $error['ApiErrorCodes']['products_detail_required']
            );
            $validatorError = Product::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // set params
            $product = new Product($input);
            $product->save();

            return $this->created($product);

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

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permission_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // validation
            $messages = array(
                'collection_id.required' => $error['ApiErrorCodes']['products_collection_id_required'],
                'categories_id.required' => $error['ApiErrorCodes']['products_categories_id_required'],
                'name.required' => $error['ApiErrorCodes']['products_name_required'],
                'detail.requireds' => $error['ApiErrorCodes']['products_detail_required']
            );
            $validatorError = Challenge::validate($input, 'RULE_UPDATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            /// find product
            $product = Product::find($id);
            if (!$product) {
                return $this->notFound($error['products_not_found'], $error['ApiErrorCodes']['products_not_found']);
            }

            // update
            $product->fill(array(
                'name' => $input['name'],
                'collection_id' => $input['collection_id'],
                'categories_id' => $input['categories_id'],
                'detail' => $input['detail'],
            ));
            $categories->save();

            return $this->success($product);

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
            // TODO destroy product
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // check permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // get product
            $product = Product::find($id);
            if (empty($product)) {
                return $this->notFound($error['users_not_found'], $error['ApiErrorCodes']['users_not_found']);
            }

            $product->delete();

            return $this->accepted($product);



        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
