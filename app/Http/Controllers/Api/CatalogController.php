    <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Role;
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
}
