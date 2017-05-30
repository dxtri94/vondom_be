<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $table = 'confirm_tokens';

    protected $fillable = array(
        'user_id',
        'token',
        'expired_at'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $casts = array(
        'user_id' => 'integer'
    );

    /**
     *
     * relation to tokens
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * fn check expired of token
     * @return mixed
     */
    public function isExpired()
    {
        return Carbon::now(env('TIMEZONE_LOCATION'))->gte(new Carbon($this->expired_at));
    }
}
