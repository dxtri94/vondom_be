    <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Catalog;
use App\Models\Platform;
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
 *   resourcePath="/Platform",
 *   description="Operation of Platform",
 *   produces="['application/json']"
 * )
 */
class CatalogController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/catalog",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Catalog",
     *      nickname="getCatalogs",
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
            // TODO get all Catalog
            $query = new Catalog();
            $catalog = $query->paginate($request->get('per_page', 10));
            return $this->success($catalog);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }


    /**
     * @SWG\Api(
     *   path="/api/catalog/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Catalog",
     *      nickname="getCatalog",
     *
     *      @SWG\Parameter( name="id", description="Catalog Id", required=true, type="integer", paramType="path", allowMultiple=false ),
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
        try {
            // TODO find Catalog by id

            $error = $this->error;
//            $authToken = $request->attributes->get('authToken');
//            $user = $authToken->user;

            // find game
            $catalog = Catalog::find($id);
            if (!$catalog) {
                return $this->notFound($error['catalogs_not_found'], $error['ApiErrorCodes']['catalogs_not_found']);
            }

            return $this->success($categories);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

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
                'name.required' => $error['ApiErrorCodes']['catalogs_name_required'],
                'link.required' => $error['ApiErrorCodes']['catalogs_link_required'],
                'link.url' => $error['ApiErrorCodes']['catalogs_link_url'],
                'description.required' => $error['ApiErrorCodes']['catalogs_description_required']
            );
            $validatorError = Catalog::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // set params
            $catalog = new Catalog($input);
            $catalog->save();

            return $this->created($catalog);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

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
                'name.required' => $error['ApiErrorCodes']['catalogs_name_required'],
                'link.url' => $error['ApiErrorCodes']['catalogs_link_url']
                'link.required' => $error['ApiErrorCodes']['catalogs_link_required'],
                'description.required' => $error['ApiErrorCodes']['catalogs_description_required']
            );
            $validatorError = Catalog::validate($input, 'RULE_UPDATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            /// find product
            $catalog = Catalog::find($id);
            if (!$catalog) {
                return $this->notFound($error['catalogs_not_found'], $error['ApiErrorCodes']['catalogs_not_found']);
            }

            // update
            $catalog->fill(array(
                'name' => $input['name'],
                'link' => $input['link'],
                'description' => $input['description']
            ));
            $catalog->save();

            return $this->success($catalog);

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
            $catalog = Catalog::find($id);
            if (!$catalog) {
                return $this->notFound($error['catalogs_not_found'], $error['ApiErrorCodes']['catalogs_not_found']);
            }

            // check input file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if($request->hasFile('type')) {
                    switch ($request->hasFile('type')) {
                        case 'main': {
                            $destinationPath = base_path(config('constants.PATH.CATALOG.MAIN') . '/' . $catalog->id);
                            // make directory path
                            if (!File::exists($destinationPath)) {
                                File::makeDirectory($destinationPath, $mode = 0777, true, true);
                            }

                            // move file
                            $file->move($destinationPath, $filename);

                            // delete file image old
                            if (File::exists($destinationPath . '/' . $catalog->main_img)) {
                                File::delete($destinationPath . '/' . $catalog->main_img);
                            }

                            // remove image
                            if ($catalog->path && File::exists($catalog->main_img)) {
                                File::delete($catalog->path);
                            }

                            // save path image of user
                            $catalog->main_img = config('constants.PATH.CATALOG.MAIN') . '/' . $catalog->id . '/' . $filename;
                            break;
                        }
                        case 'sub':{
                            $destinationPath = base_path(config('constants.PATH.CATALOG.SUB') . '/' . $catalog->id);
                            // make directory path
                            if (!File::exists($destinationPath)) {
                                File::makeDirectory($destinationPath, $mode = 0777, true, true);
                            }

                            // move file
                            $file->move($destinationPath, $filename);

                            // delete file image old
                            if (File::exists($destinationPath . '/' . $catalog->sub_img)) {
                                File::delete($destinationPath . '/' . $catalog->sub_img);
                            }

                            // remove image
                            if ($catalog->path && File::exists($catalog->sub_img)) {
                                File::delete($catalog->path);
                            }

                            // save path image of user
                            $catalog->sub_img = config('constants.PATH.CATALOG.SUB') . '/' . $catalog->id . '/' . $filename;
                            break;
                        }

                        default:
                            return $this->badRequest($error['catalogs_img_which_required'], $error['ApiErrorCodes']['catalogs_img_which_required']);
                            break;
                    }
                    
                }
            }
            $catalog->save();

            return $this->success($catalog);
            

            return $this->notFound($error['catalogs_file_required'], $error['ApiErrorCodes']['catalogs_file_required']);
        } catch (\Exception $e) {
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
            $catalog = Catalog::find($id);
            if (empty($catalog)) {
                return $this->notFound($error['catalogs_not_found'], $error['ApiErrorCodes']['catalogs_not_found']);
            }

            $catalog->delete();

            return $this->accepted($catalog);



        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
