<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Jobs\ChargeBuyer;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use League\Flysystem\Exception;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Abstracts",
 *   description="Operation of Roles",
 *   produces="['application/json']"
 * )
 */
class AbstractController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/stat",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Statistics of System",
     *      nickname="getStat",
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=401, message="Permission denied | Caller is not authenticated")
     *   )
     * )
     */
    public function getStatistics(Request $request)
    {
        try {

            return $this->success(array(
                'num_of_approvals' => Product::where('products.is_deleted', false)
                    ->where('status', config('constants.PRODUCT_STATUS.PENDING'))
                    ->count(),
                'num_of_reports' => Report::where('ignore', false)
                    ->get()
                    ->count()
            ));

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function test(Request $request)
    {
        try {

            $product = Product::find(1024);

            dispatch(new ChargeBuyer($product));

        } catch (Exception $ex) {
            return $this->badRequest($ex->getMessage());
        }
    }
}