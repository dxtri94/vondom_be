<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\BaseModel;
use Illuminate\Support\Facades\File;

class User extends BaseModel
{
    protected $table = 'users';
    protected $fillable = array(
        'username',
        'password',
        'is_deleted'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $casts = array(
        'role_id' => 'integer',
        'is_deleted' => 'boolean'
    );

    protected $appends = array(
        'avatar_src',
        'avatar_thumbnail',
        'type_image'
    );

    public $perPage = 20;

    public static $rules = array(
        'RULE_CREATE' => array(
            'username' => 'required|min:6|max:100|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'confirm_email' => 'required|same:email',
            'password' => [
                'required',
                'min:8',
                'max:36',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'confirm_password' => 'required|same:password',
            'location_id' => 'required|integer',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'is_term_condition' => 'required|boolean',
            'is_privacy_policy' => 'required|boolean',
            'is_subscribe_email' => 'boolean'
        ),
        'RULE_LOGIN' => array(
            'username' => 'required',
            'password' => 'required'
        ),

        'RULE_LOGIN_SOCIAL' => array(
            'social_id' => 'required',
            'social_type' => 'required'
        ),
        'RULE_FORGOT_PASSWORD' => array(
            'email' => 'required|email'
        ),
        'RULE_RESET_PASSWORD' => array(
            'token' => 'required',
            'password' => [
                'required',
                'min:8',
                'max:36',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'confirm_password' => 'required|same:password'
        ),
        'RULE_RESEND_VERIFY_EMAIL' => array(
            'email' => 'required|email'
        ),
        'RULE_CHANGE_PASSWORD' => array(
            'current_password' => 'required',
            'password' => [
                'required',
                'min:6',
                'max:36',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'confirm_password' => 'required|same:password'
        ),
        'RULE_UPDATE_ME' => array(
            'username' => 'required|min:6|max:1000',
            'email' => 'required|email',
            'phone' => 'required|min:2|max:11'
        ),
        'RULE_UPDATE_ADDITIONAL_INFO' => array(
            'username' => 'required|min:6|max:100|unique:users,username',
            'location_id' => 'required',
            'phone' => 'required|min:8|max:14|regex:/^([0-9])+$/i'
        )
    );

    /**
     * get created iso6801 datetime attribute
     * @param $value
     * @return carbon
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(Carbon::ISO8601);
    }

    /**
     * get updated iso6801 datetime attribute
     * @param $value
     * @return carbon
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(Carbon::ISO8601);
    }

    /**
     * get avatar src attribute
     * @return string
     */
    public function getAvatarSrcAttribute()
    {
        if (isset($this->social_type) AND strpos($this->path, 'http') !== false) {
            return $this->path;
        } else if (File::exists($this->path)) {
            return url("/api/images/users/$this->id?ver=" . rand(0, 1000000));
        }

        return null;
    }

    /**
     * fn get thumbnail attribute
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
     */
    public function getAvatarThumbnailAttribute()
    {
        if (isset($this->social_type) AND strpos($this->path, 'http') !== false) {
            return $this->path;
        } else if ($this->path) {
            return url("/api/images/users/$this->id/thumbnail?ver=" . rand(0, 1000000));
        }
    }

    /**
     * get type image attribute
     * @return bool|string
     */
    public function getTypeImageAttribute()
    {
        return $this->path ? $this->checkSizeImage($this->path) : null;
    }

    /**
     * fn check deleted account
     * @return bool
     */
    public function isDeleted()
    {
        return !!$this->is_deleted;
    }

    /**
     * fn check account type as admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id === config('constants.ROLEs.ADMIN') || $this->isSuperAdmin();
    }

    public function isUser()
    {
        return $this->role_id === config('constants.ROLEs.USER');
    }

    /**
     * relation to roles
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    /**
     * relation to results
     */
    public function result()
    {
        return $this->hasOne('App\Models\Result', 'user_id', 'id')->orderBy('id', 'desc');
    }

    /**
     * relation to tokens
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function token()
    {
        return $this->belongsTo('App\Models\Token', 'user_id')
            ->orderBy('id', 'desc');
    }
}