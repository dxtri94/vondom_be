<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Dispute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Pagination;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Response;
use Nexmo\Laravel\Facade\Nexmo;

use OneSignal\Config;
use OneSignal\Devices;
use OneSignal\OneSignal;


class ApiBasicController extends Controller
{
    protected $statusCode = 200;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * fn respond with success
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function respondSuccess($data = array(), array $headers = [])
    {
        $this->setStatusCode(200);

        $response = array(
            'data' => $data,
            'error' => null,
            'errors' => null
        );

        return response()->json($response, $this->statusCode, $headers);
    }

    /**
     * fn respond success - the standard response for processing successfully
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function success($data = array(), $headers = array())
    {
        $this->setStatusCode(200);
        return response()->json(array(
            'data' => $data,
            'error' => false,
            'errors' => null
        ), $this->statusCode, $headers);
    }

    /**
     * fn respond created - the standard response for processing successfully
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function created($data = array(), $headers = array())
    {
        $this->setStatusCode(201);
        return response()->json(array(
            'data' => $data,
            'error' => false,
            'errors' => null
        ), $this->statusCode, $headers);
    }

    /**
     * fn respond accepted - the request has been accepted for processing
     * @param array $headers
     * @return mixed
     */
    public function accepted($data = array(), $headers = array())
    {
        $this->setStatusCode(202);
        return response()->json(array(
            'data' => $data,
            'error' => false,
            'errors' => null
        ), $this->statusCode, $headers);
    }

    /**
     * fn response no content - The server successfully processed the request and is not returning any content.
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent($headers = array())
    {
        $this->setStatusCode(204);
        return response()->json(array(
            'data' => null,
            'error' => false,
            'errors' => null
        ), $this->statusCode, $headers);
    }

    /**
     * fn respond forbidden - The request was a valid request
     * @param string $message
     * @param null $errorCode
     * @return mixed
     */
    public function forbidden($message = '', $errorCode = null)
    {
        $this->setStatusCode(403);
        return $this->respondWithErrorMessage($message, $errorCode, $this->statusCode);
    }

    /**
     * fn response bad request - server cannot or will not process the request
     * @param string $message
     * @param null $errorCode
     * @return mixed
     */
    public function badRequest($message = '', $errorCode = null, $data = null)
    {
        $this->setStatusCode(400);
        if (isset($data)) {
            return $this->respondWithErrorMessage2($data, $message, $errorCode, $this->statusCode);
        }
        return $this->respondWithErrorMessage($message, $errorCode, $this->statusCode);
    }

    /**
     * fn response not found - server requested resource could be not found
     * @param string $message
     * @param null $errorCode
     * @return mixed
     */
    public function notFound($message = '', $errorCode = null)
    {
        $this->setStatusCode(404);
        return $this->respondWithErrorMessage($message, $errorCode, $this->statusCode);
    }

    /**
     * fn respond with error messages
     * @param $errorMessage
     * @param null $errorCode
     * @param null $statusCode
     * @param array $headers
     * @return mixed
     */
    public function respondWithErrorMessage($errorMessage, $errorCode = null, $statusCode = null, array $headers = [])
    {
        if (empty($statusCode)) {
            $this->setStatusCode(400);
        } else {
            $this->setStatusCode($statusCode);
        }

        $response = array(
            'error' => true,
            'data' => null,
            'errors' => array(
                array(
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage
                )
            )
        );

        return response()->json($response, $this->statusCode, $headers);
    }

    /**
     * fn respond with error messages
     * @param $errorMessage
     * @param null $errorCode
     * @param null $statusCode
     * @param array $headers
     * @return mixed
     */
    public function respondWithErrorMessage2($data = null, $errorMessage = '', $errorCode = null, $statusCode = null, array $headers = [])
    {
        if (empty($statusCode)) {
            $this->setStatusCode(400);
        } else {
            $this->setStatusCode($statusCode);
        }

        $response = array(
            'error' => true,
            'data' => $data,
            'errors' => array(
                array(
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage
                )
            )
        );

        return response()->json($response, $this->statusCode, $headers);
    }

    /**
     * fn respond with error
     * @param $errors
     * @param null $statusCode
     * @param array $headers
     * @return mixed
     */
    public function respondWithError($errors, $statusCode = null, $headers = array())
    {
        if (empty($statusCode)) {
            $this->setStatusCode(400);
        } else {
            $this->setStatusCode($statusCode);
        }

        $errorsList = array();
        foreach ($errors as $error) {
            $errorsList[] = array(
                'errorMessage' => $error[0],
                'errorCode' => (int)$error[1]
            );
        }

        return response()->json(array(
            'error' => true,
            'data' => null,
            'errors' => $errorsList
        ), $this->statusCode, $headers);
    }

    /**
     * fn respond file
     * @param null $file_path
     * @return mixed
     */
    public function respondFile($file_path = null)
    {
        if (empty($file_path)) {
            $file_path = config('constants.NO_IMAGE');
        }

        $file = File::get($file_path);
        $type = File::mimeType($file_path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * fn respond view
     * @param string $view
     * @param array $params
     * @return \Illuminate\Http\Response
     */
    public function respondView($view = '', $params = array())
    {
        return response()->view($view, $params);
    }

    /**
     * fn check file size
     * @param $sizeFile
     * @return bool
     */
    public function checkSizeFile($sizeFile)
    {
        return $sizeFile > config('constants.FILE_SIZE.DATA');
    }

    /**\
     * fn crop image
     * @param $file
     * @param array $size
     * @return bool|resource
     */
    protected function cropImage($file, $size = array())
    {
        if ($file) {
            $size = (object)$size;

            // Create a blank image and add some text
            $immage = imagecreatefromjpeg($file);

            // get size of image
            $x_size = (getimagesize($file)[0]);
            $y_size = (getimagesize($file)[1]);

            // set center image
            $centerX = ($x_size > $size->width) ? ($x_size / 2 - $size->width / 2) : 0;
            $centerY = ($y_size > $size->height) ? ($y_size / 2 - $size->height / 2) : 0;


            // info crop image
            $crop_array = array(
                'x' => $centerX,
                'y' => $centerY,
                'width' => ($x_size > $size->width) ? $size->width : $x_size,
                'height' => ($y_size > $size->height) ? $size->height : $y_size
            );

            // crop image
            $thumbnail = imagecrop($immage, $crop_array);

            // set header
            header('Content-type: image/jpeg');
            imagejpeg($thumbnail);

            return $thumbnail;
        }

        return false;
    }

    /**
     * fn resize image
     * @param $file
     * @param $size
     * @return bool
     */
    protected function resizeImage($file, $size)
    {
        if ($file) {
            $size = (object)$size;
            $width = getimagesize($file)[0];
            $height = getimagesize($file)[1];

            $widthPercent = ($width / $size->width) * 100;
            $heightPercent = ($height / $size->height) * 100;

            $image = Image::make($file);

            // percent reize width > height
            if ($widthPercent > $heightPercent) {
                $heightNew = ceil(($height / $widthPercent) * 100);
                $image->resize($size->width, $heightNew)->save($file);
            } else {
                $widthNew = ceil(($width / $heightPercent) * 100);
                $image->resize($widthNew, $size->height)->save($file);
            }

            return $image;
        }
        return false;
    }

    /**
     * fn generate password
     * @param int $length
     * @return string
     */
    protected function generatePassword($length = 8)
    {
        //string uses random password
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //random password
        return substr(str_shuffle($characters), 0, $length);
    }

    protected function generateNumberCode($length = 6)
    {
        //string uses random password
        $characters = "0123456789";
        //random password
        return substr(str_shuffle($characters), 0, $length);
    }

    /**
     * @return mixed
     */
    protected function generateToken()
    {
        return strtoupper(md5(uniqid()));
    }


    /**
     * fn detect account is system user
     * @param $token
     * @return bool
     */
    protected function isAdmin($token)
    {
        return $token->user->role->id !== config('constants.ROLES.USER');
    }

    /**
     * fn detect account is system user
     * @param $token
     * @return bool
     */
    protected function isUser($token)
    {
        return $token->user->role->id <= config('constants.TOKEN_TYPES.USER');
    }

    /**
     * pagination
     * @param array $items
     * @param int $page
     * @return Paginator
     */
    protected function paginate($items = array(), $page = 1)
    {
        // custom items per page
        $perPage = config('constants.PER_PAGE.DEFAULT');
        $itemResults = $items->slice(($page - 1) * $perPage, $perPage);

        return new Paginator($itemResults, count($items), $perPage, $page);
    }


    /**
     * fn check token expired
     * @return bool
     */
    public function isExpired($expired_at)
    {
        $today = Carbon::now(env('TIMEZONE_LOCATION'));

        return $expired_at ? $today->gte($expired_at) : true;
    }

    /**
     * fn pagination
     * @param $data
     * @param $pageStart
     * @param $perPage
     * @return array
     */
    public function pagination($data, $pageStart, $perPage)
    {
        // pagination
        $pagination = new Paginator($data, count($data), $perPage, $pageStart);
        $results = $pagination->toArray();
        return array(
            'total' => $results['total'],
            'current_page' => $results['current_page'],
            'per_page' => $results['per_page'],
            'last_page' => $results['last_page'],
            'data' => $results['data']
        );
    }

    /**
     * fn send message by OTP
     * @param string $number
     * @param string $brand
     * @return string
     */
    public function sendVerifyOTP($number = '', $brand='')
    {
        try {
            // send OTP
            $response = Nexmo::verify()->start(array(
                'number' => $number,
                'brand' => $brand
                ));

            // send OTP success
            if ($response->getRequestId()) {
                return $response->getRequestId();
            } else {
                return null;
            }
        } catch (\Nexmo\Client\Exception\Exception $e) {
            return $e->getCode();
        }
    }

    /**
     * fn send message by email
     * @param string $template
     * @param array $data
     * @param string $subject
     * @param array $from
     * @param array $to
     * @return bool
     */
    public function sendEmailMessage($template = '', $data = array(), $subject = '', $from = array(), $to = array())
    {
        try {
            // send email
            Mail::send($template, $data, function ($message) use ($from, $to, $subject) {

                if (!empty($from)) {
                    $message->from($from['email'], $from['name']);
                } else {
                    $message->from(config('constants.EMAILS.EMAIL'), config('constants.EMAILS.NAME'));
                }
                $message->to($to['email'], $to['name'])
                    ->subject($subject);
            });

            // send email success
            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * fn send notification to user with challenge
     * @param string $title
     * @param string $content
     * @param null $labels
     * @param null $to receiver
     * @param null $with challenge
     * @return Notification|null
     */
    public function sendNotifyTo($title = '', $content = '', $labels = null, $to = null, $with = null)
    {
        try {

            $notification = new Notification(array(
                'user_id' => $to->id,
                'challenge_id' => $with->id,
                'title' => $title,
                'content' => $content,
                'labels' => $labels,
                'status' => config('constants.NOTIFICATION_STATUS.NEW')
            ));
            $notification->save();

            return $notification;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * push notification into one signal
     * @param null $device_token
     * @param null $title
     * @param null $message
     * @param null $notification_type
     * @param null $device_type
     * @return bool
     */
    public function pushNotification($device_token = null, $title = null, $message = null, $notification_type = null, $device_type = null)
    {
        try {
            $config = new Config();
            $config->setApplicationId(env('ONESIGNAL_APP_ID'));
            $config->setUserAuthKey(env('ONESIGNAL_USER_AUTH_KEY'));
            $this->api_one_signal = new OneSignal($config);

            if ($device_token && $device_type) {
                // get device
                $device = $this->getOneSignal($device_token, $device_type);
                if (!!$device->success) {

                    // Push notification
                    $this->api_one_signal->notifications->add([
                        'contents' => [
                            'en' => $message
                        ],
                        'headings' => [
                            'en' => $title
                        ],
                        'include_player_ids' => [$device->id],
                        'data' => [
                            'type' => $notification_type
                        ]
                    ]);
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * get one signal
     * @param $device_token
     * @param $device_type
     * @return bool|object
     */
    public function getOneSignal($device_token, $device_type)
    {
        try {
            $data = [];
            switch ($device_type) {
                case config('constants.DEVICE_TYPE.CHROME'): {
                    $data = array(
                        'device_type' => Devices::CHROME_WEB,
                        'identifier' => $device_token
                    );
                    break;
                }
                case config('constants.DEVICE_TYPE.FIREFOX'): {
                    $data = array(
                        'device_type' => Devices::FIREFOX,
                        'identifier' => $device_token
                    );
                    break;
                }
                case config('constants.DEVICE_TYPE.SAFARI'): {
                    $data = array(
                        'device_type' => Devices::SAFARI,
                        'identifier' => $device_token
                    );
                    break;
                }
                case config('constants.DEVICE_TYPE.IOS'): {
                    $data = array(
                        'device_type' => Devices::IOS,
                        'identifier' => $device_token
                    );
                    break;
                }
                case config('constants.DEVICE_TYPE.ANDROID'): {
                    $data = array(
                        'device_type' => Devices::ANDROID,
                        'identifier' => $device_token
                    );
                    break;
                }
            }

            // get one signal
            // return device ID
            $device = $this->api_one_signal->devices->add($data);

            return (object)$device;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Lookup address from google API , detect lat, long
     * @param $string
     * @return array|null
     */
    public function lookup($string)
    {
        $string = str_replace(" ", "+", urlencode($string));
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $string . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            return null;
        }

        $results = $response['results'];
        $firstResult = $results[0];

        $array = array(
            'lat' => $firstResult['geometry']['location']['lat'],
            'lng' => $firstResult['geometry']['location']['lng'],
            'address' => $firstResult['formatted_address']
        );

        return $array;
    }
}