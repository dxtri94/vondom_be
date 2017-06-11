<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Categories;
use App\Models\Collection;
use App\Models\Product;
use App\Models\News;
use App\Models\Image;
use App\Models\Catalog;
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

    public function getCategoriesImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $categories = Categories::find($id);

            if ($categories) {
                if ($categories->img_path AND File::exists(base_path($categories->img_path))) {
                    return $this->respondFile(base_path($categories->img_path));
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
    public function getCategoriesThumbnail(Request $request, $id = 0)
    {
        try {

            $categories = Categories::find($id);

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
            if ($categories) {
                if (!!$categories->img_path && File::exists(base_path($categories->img_path))) {

                    $thumbnail = $this->resizeImage(base_path($categories->img_path), $size);
                    return $thumbnail->response(File::extension(base_path($categories->img_path)));
                }
            }

            return $this->respondFile();
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getCollectionImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $collection = Collection::find($id);

            if ($collection) {
                if ($collection->image AND File::exists(base_path($collection->image))) {
                    return $this->respondFile(base_path($collection->image));
                }
            }
           
            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getproductImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $product = Product::find($id);

            if ($product) {
                if ($product->image AND File::exists(base_path($product->image))) {
                    return $this->respondFile(base_path($product->image));
                }
            }
           
            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getCatalogMainImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $catalog = Catalog::find($id);

            if ($catalog) {
                if ($catalog->main_img AND File::exists(base_path($catalog->main_img))) {
                    return $this->respondFile(base_path($catalog->main_img));
                }
            }
           
            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getCatalogSubImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $catalog = Catalog::find($id);

            if ($catalog) {
                if ($catalog->sub_img AND File::exists(base_path($catalog->sub_img))) {
                    return $this->respondFile(base_path($catalog->sub_img));
                }
            }
           
            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function getNewsImage(Request $request, $id = 0)
    {
        try {
            // TODO get game image

            $news = News::find($id);

            if ($news) {
                if ($news->image AND File::exists(base_path($news->image))) {
                    return $this->respondFile(base_path($news->image));
                }
            }
           
            return $this->respondFile();

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}