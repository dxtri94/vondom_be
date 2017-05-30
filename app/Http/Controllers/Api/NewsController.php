<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Newsletters",
 *   description="Operation of Newsletters",
 *   produces="['application/json']"
 * )
 */
class NewsController extends ApiBasicController
{
    public function __construct(Request $request)
    {
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/newsletters",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Newsletter",
     *      nickname="getNewsletter",
     *
     *      @SWG\Parameter(name="per_page", description="Items per page", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="type", description="Type [top]", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="len", description="Length of Top Newsletters [top]", required=false, type="string", paramType="query", allowMultiple=false),
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
            $query = new News();
            $news = $query->paginate($request->get('per_page', 10));
            return $this->success($news);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function get(Request $request, $id = 0)
    {
        try {
            // TODO get single news

            $error = $this->error;

            // find newsletter
            $news = News::find($id);

            if (!$news) {
                return $this->notFound($error['news_not_found'], $error['ApiErrorCodes']['news_not_found']);
            }

            return $this->success($news);

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
                'title.required' => $error['ApiErrorCodes']['newsletters_title_required'],
                'title.min' => $error['ApiErrorCodes']['newsletters_title_min'],
                'title.max' => $error['ApiErrorCodes']['newsletters_title_max'],
                'content.required' => $error['ApiErrorCodes']['newsletters_content_required']
            );
            $validatorError = Newsletter::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // create
            $newsletter = new Newsletter($input);
            $newsletter->save();

            return $this->created($newsletter);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function update(Request $request, $id = 0)
    {
        try {
            // TODO update an newsletter

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
                'title.required' => $error['ApiErrorCodes']['newsletters_title_required'],
                'title.min' => $error['ApiErrorCodes']['newsletters_title_min'],
                'title.max' => $error['ApiErrorCodes']['newsletters_title_max'],
                'content.required' => $error['ApiErrorCodes']['newsletters_content_required']
            );
            $validatorError = Newsletter::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // find newsletter
            $newsletter = Newsletter::find($id);
            if (!$newsletter) {
                return $this->notFound($error['newsletters_not_found'], $error['ApiErrorCodes']['newsletters_not_found']);
            }

            // update new letter
            $newsletter->fill($input);
            $newsletter->save();

            return $this->success($newsletter);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function destroy(Request $request, $id = 0)
    {
        try {
            // TODO delete an newsletter

            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // detect permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permission_access_denied'], $error['ApiErrorCodes']['permission_access_denied']);
            }

            // find newsletter
            $newsletter = Newsletter::find($id);
            if (!$newsletter) {
                return $this->notFound($error['newsletters_not_found'], $error['ApiErrorCodes']['newsletters_not_found']);
            }

            $newsletter->delete();

            return $this->accepted($newsletter);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}