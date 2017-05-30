<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthToken extends BaseModel
{
    protected $table = 'tokens';

    protected $fillable = array(
        'token',
        'user_id',
        'expired_at',
        'is_remember',
        'timezone'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $casts = array(
        'is_remember' => 'boolean',
        'timezone' => 'integer'
    );

    protected $dates = array(
        'created_at',
        'updated_at',
        'expired_at'
    );

    /**
     * get created iso6801 datetime attribute
     * @param $value
     * @return float
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(Carbon::ISO8601);
    }

    /**
     * get updated iso6801 datetime attribute
     * @param $value
     * @return float
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(Carbon::ISO8601);
    }

    /**
     * fn relate to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')
            ->where('is_deleted', false);
    }

    /**
     * Login as Company
     * @param string $email
     * @param string $password
     * @param bool $is_remember
     * @return null|object
     */
    public static function login($email = '', $password = '', $is_remember = false, $timezone = 0)
    {
        try {
            $userCredential = User::where('email', $email)->first();

            // check user and password
            if ($userCredential && Hash::check($password, $userCredential->password)) {

                $user = clone $userCredential;
                $user['permission'] = $userCredential->role->role;

                // store new token
                $authToken = new AuthToken();
                $authToken->fill(array(
                    'token' => AuthToken::genToken($email . $password),
                    'user_id' => $userCredential->id,
                    'expired_at' => Carbon::now()->addHours(2)->toDateTimeString(),
                    'is_remember' => (boolean)$is_remember,
                    'timezone' => $timezone
                ));
                $authToken->save();

                $userCredential->fill(array(
                    'last_login' => date('Y-m-d H:i:s', time())
                ));

                $userCredential->save();
                unset($userCredential->password);
                $user->role;

                return (object)array(
                    'token' => $authToken->token,
                    'user' => $user
                );
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * fn login by social network
     * @param string $email
     * @param string $social
     * @param bool $is_remember
     * @param int $timezone
     * @return null|object
     */
    public static function loginBySocialNetwork($email = '', $social_id = '', $social = '', $is_remember = false, $timezone = 0)
    {
        try {
            // find user by email and social network
            //$userCredential = User::where('email', $email)->where('social_type', $social)->first();
            //$userCredential = User::where('social_id')->where('social_type', $social)->first();
            $userCredential = User::where('social_type', $social)
                ->where(function ($query) use($social_id) {
                    $query->where('social_id', $social_id);
                })->first();

            if (!!$userCredential) {
                $user = clone $userCredential;

                $authToken = new AuthToken();
                $authToken->fill(array(
                    'token' => AuthToken::genToken($email),
                    'user_id' => $userCredential->id,
                    'timezone' => $timezone,
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+2400 hours')),
                    'is_remember' => $is_remember
                ));
                $authToken->save();

                $userCredential->fill(array(
                    'last_login' => date('Y-m-d H:i:s')
                ));
                $userCredential->save();

                unset($user->password);

                return (object)array(
                    'token' => $authToken->token,
                    'user' => $user
                );
            }

            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * fn check token expired
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now(env('TIMEZONE_LOCATION'))->gte($this->expired_at);
    }

    /**
     * Is remember
     *
     * @return bool
     */
    public function isRemembered()
    {
        return (boolean)$this->is_remember;
    }

    /**
     * fn extend expired token
     */
    public function extend()
    {
        $this->expired_at = Carbon::now()->addHours(2)->toDateTimeString();
        $this->save();
    }

    /**
     * generate token
     * @param string $secret
     * @return string
     */
    public static function genToken($secret = '')
    {
        return strtoupper(md5((string)(time() + rand(0, 1000)) . $secret));
    }
}