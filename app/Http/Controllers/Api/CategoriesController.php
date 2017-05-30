<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBasicController;
use App\Models\Categories;
use App\Models\Favourite;
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
     *   path="/api/games/",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Games",
     *      nickname="getGames",
     *
     *      @SWG\Parameter(name="type", description="type [top]", required=false, type="string", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="len", description="items per page", required=false, type="integer", paramType="query", allowMultiple=false),
     *      @SWG\Parameter(name="platform_id", description="get by platform", required=false, type="integer", paramType="query", allowMultiple=false),
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
     *   path="/api/games/{id}",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get single Game",
     *      nickname="getGame",
     *
     *      @SWG\Parameter( name="id", description="Game Id", required=true, type="integer", paramType="path", allowMultiple=false ),
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
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // find game
            $game = Game::with(array(
                'platform'
            ))->find($id);
            if (!$game) {
                return $this->notFound($error['games_not_found'], $error['ApiErrorCodes']['games_not_found']);
            }

            // get favourite
            $game->getFavouriteBy($user);

            return $this->success($game);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    /**
     * @SWG\Api(
     *   path="/api/games/{id}/opponents",
     *   @SWG\Operation(
     *      method="GET",
     *      summary="Get Opponents in Game",
     *      nickname="getGameOpponents",
     *
     *      @SWG\Parameter( name="id", description="Game ID", required=true, type="integer", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="type", description="type [pending|activated]", required=false, type="string", paramType="path", allowMultiple=false ),
     *      @SWG\Parameter( name="per_page", description="Item per page", required=true, type="integer", paramType="query", allowMultiple=false ),
     *
     *      @SWG\ResponseMessage(code=200, message="Success"),
     *      @SWG\ResponseMessage(code=400, message="Permission Denied | Have Error in System"),
     *      @SWG\ResponseMessage(code=401, message="Caller is not authenticated"),
     *      @SWG\ResponseMessage(code=404, message="Resource not found"),
     *   )
     * )
     */
    public function getOpponents(Request $request, $id = 0)
    {
        
    }

    public function create(Request $request)
    {
        try {
            // TODO create new game
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;
            $input = $request->input();

            // detect user permission
            if (!$user->isAdmin()) {
                return $this->badRequest($error['permissions_access_denied'], $error['ApiErrorCodes']['permissions_access_denied']);
            }

            // validate
            $messages = array();
            $validatorError = Game::validate($input, 'RULE_CREATE', $messages);
            if (!empty($validatorError)) {
                return $this->respondWithError($validatorError);
            }

            // create new game
            $game = new Game($input);
            $game->save();

            return $this->created($game);
        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function upload(Request $request, $id = 0)
    {
        try {
            // TODO upload image to game

            $error = $this->error;

            // find game
            $game = Game::find($id);
            if (empty($game)) {
                return $this->notFound($error['games_not_found'], $error['ApiErrorCodes']['games_not_found']);
            }

            // clear current file
            if (File::exists(base_path($game->path))) {
                File::delete(base_path($this->path));
            }

            // upload file
            $files = $request->file();
            if (isset($files[0])) {
                $result = $this->uploadFile($game, $files[0]);

                if (!$result) {
                    return $this->badRequest($error['games_file_not_upload'], $error['ApiErrorCodes']['games_file_not_upload']);
                }

                return $this->success($game);
            }

            return $this->badRequest($error['games_file_not_found'], $error['ApiErrorCodes']['games_file_not_found']);

        } catch (Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function favouriteTo(Request $request, $id = 0)
    {
        try {
            // TODO set favourite to game
            $error = $this->error;
            $authToken = $request->attributes->get('authToken');
            $user = $authToken->user;

            // find game
            $game = Game::find($id);
            if (empty($game)) {
                return $this->badRequest($error['games_not_found'], $error['ApiErrorCodes']['games_not_found']);
            }

            // find current favourite
            $favourite = Favourite::where('game_id', $game->id)
                ->where('user_id', $user->id)
                ->first();
            if (empty($favourite)) {
                // create favourite

                $favourite = new Favourite(array(
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'is_favourite' => true
                ));
                $favourite->save();

            } else {
                // delete current
                $favourite->delete();
            }

            $game->getFavouriteBy($user);

            return $this->accepted($game);

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

    /**
     * fn upload file to game
     * @param array $game
     * @param $file null
     * @return bool
     */
    private function uploadFile($game = array(), $file = null)
    {
        // TODO detect file and move fiel to system
        if ($game AND $file) {

            $destinationPath = config('constants.PATH.GAME');
            $filename = $game->id . '.' . $file->getClientOriginalExtension();

            // make directory path
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
            }

            // move file
            $file->move(base_path($destinationPath), $filename);

            // update game
            $game->fill(array(
                'path' => "$destinationPath/$filename"
            ));
            $game->save();

            return true;
        }

        return false;
    }
}
