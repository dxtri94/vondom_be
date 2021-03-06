<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Categories;
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
class CategoriesController extends ApiBasicController
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
            $query = new Categories();
            $categories = $query->paginate($request->get('per_page', 10));
            return $this->success($categories);
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
            $categories = Categories::with(array(
                    'product',
                    'product.collection'
                ))
            ->find($id);
            if (!$categories) {
                return $this->notFound($error['categories_not_found'], $error['ApiErrorCodes']['categories_not_found']);
            }

            return $this->success($categories);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getProduct(Request $request, $id = 0)
    {
        try {
            // TODO find game by id

            $error = $this->error;
//            $authToken = $request->attributes->get('authToken');
//            $user = $authToken->user;

            // find categories
            $categories = Categories::find($id);
            if (!$categories) {
                return $this->notFound($error['categories_not_found'], $error['ApiErrorCodes']['categories_not_found']);
            }

            $query = Product::where('categories_id', $id)
                ->orderBy('updated_at', 'DESC');

            $product = $query->paginate($request->get('per_page', 10));
            
            return $this->success($product);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            // TODO create new newsletter

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
                'name.required' => $error['ApiErrorCodes']['categories_name_required']
            );
            $validatorError = Categories::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // create
            $categories = new Categories($input);
            $categories->save();

            return $this->created($categories);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function update(Request $request, $id = 0)
    {
        try {
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
                'name.required' => $error['ApiErrorCodes']['categories_name_required']
            );
            $validatorError = Categories::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // find categories
            $categories = Categories::find($id);
            if (!$categories) {
                return $this->notFound($error['categories_not_found'], $error['ApiErrorCodes']['categories_not_found']);
            }

            // update
            $categories->fill(array(
                'name' => $input['name']
            ));
            $categories->save();

            return $this->success($categories);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function upload(Request $request, $id)
    {
        try {
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permission_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // find categories
            $categories = Categories::find($id);
            if (!$categories) {
                return $this->notFound($error['categories_not_found'], $error['ApiErrorCodes']['categories_not_found']);
            }

            // check input file
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // TODO upload
                $destinationPath = base_path(config('constants.PATH.CATEGORIES') . '/' . $categories->id);
                $filename = date('m-d-Y-H-i-s') . '-' . $categories->id . '.' . $file->getClientOriginalExtension();

                // make directory path
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                // move file
                $file->move($destinationPath, $filename);

                // delete file image old
                if (File::exists($destinationPath . '/' . $categories->img_path)) {
                    File::delete($destinationPath . '/' . $categories->img_path);
                }

                // remove image
                if ($categories->path && File::exists($categories->img_path)) {
                    File::delete($categories->path);
                }

                // save path image of user
                $categories->img_path = config('constants.PATH.CATEGORIES') . '/' . $categories->id . '/' . $filename;
                $categories->save();

                return $this->success($categories);
            }

            return $this->notFound($error['categories_file_required'], $error['ApiErrorCodes']['categories_file_required']);
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function destroy(Request $request, $id = 0)
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
            $categories = Categories::find($id);
            if (empty($product)) {
                return $this->notFound($error['categories_not_found'], $error['ApiErrorCodes']['categories_not_found']);
            }

            $categories->delete();

            return $this->accepted($categories);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
