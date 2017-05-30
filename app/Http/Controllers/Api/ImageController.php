<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Game;
use App\Models\Image;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   resourcePath="/Image",
 *   description="Operation of Image",
 *   produces="['application/json']"
 * )
 */
class ImageController extends ApiBasicController
{
    // constructor
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = Lang::get('errorCodes');
        parent::__construct($request);
    }

    /**
     * @SWG\Api(
     *   path="/api/image/game/{id}?ver=",
     *   @SWG\Operation(
     *     summary="getGameImage",
     *     method="GET",
     *     nickname="gameImage",
     *
     *     @SWG\ResponseMessage(code=202, message="Accepted"),
     *     @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *     @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function getGameImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $game = Game::find($id);

            if ($game) {
                if ($game->path AND File::exists(base_path($game->path))) {
                    return $this->respondFile(base_path($game->path));
                }
            }

            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/image/game/{id}?ver=/thumbnail",
     *   @SWG\Operation(
     *     summary="getGameImageThumbnail",
     *     method="GET",
     *     nickname="gameImage",
     *
     *     @SWG\ResponseMessage(code=202, message="Accepted"),
     *     @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *     @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function getGameThumbnail(Request $request, $id = 0)
    {
        try {

            $game = Game::find($id);

            $size = array(400, 400);
            if ($request->has('size')) {
                $size = $request->get('size', array(400, 380));

                if (is_string($size)) {
                    $list = explode(',', $size);

                    if (count($list) === 1) {
                        $size = array((int)$size, (int)$size);
                    } else if (count($list) > 1) {
                        $size = array(!!(int)$list[0] ? (int)$list[0] : 400, !!(int)$list[1] ? (int)$list[1] : 380);
                    }
                }
            }

            // check image
            if ($game) {
                if (!!$game->path && File::exists(base_path($game->path))) {

                    $thumbnail = $this->resizeImage(base_path($game->path), $size);
                    return $thumbnail->response(File::extension(base_path($game->path)));
                }
            }

            return $this->respondFile();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
    /**
     * @SWG\Api(
     *   path="/api/images/result/{hash}?ver=",
     *   @SWG\Operation(
     *     summary="getResultImage",
     *     method="GET",
     *     nickname="gameImage",
     *
     *     @SWG\ResponseMessage(code=202, message="Accepted"),
     *     @SWG\ResponseMessage(code=401, message="Authorization Expired"),
     *     @SWG\ResponseMessage(code=404, message="Resource not found")
     *   )
     * )
     */
    public function getResultImage(Request $request, $hash = '')
    {
        try {
            // TODO get result image

            //find image
            $image = Image::where('hash', $hash)->first();

            if ($image) {
                if ($image->path AND File::exists(base_path($image->path))) {
                    return $this->respondFile(base_path($image->path));
                }
            }

            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}